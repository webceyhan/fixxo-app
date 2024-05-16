<?php

namespace App\Enums;

use App\Enums\Concerns\Completable;
use App\Enums\Concerns\HasValues;
use App\Models\Device;

enum DeviceStatus: string
{
    use HasValues, Completable;

        // The device has been brought in for repair and is waiting to be checked by a technician.
    case CheckedIn = 'checked_in';

        // The technician is currently diagnosing the problem with the device.
        // case DIAGNOSING = 'diagnosing';

        // The technician is currently repairing the device.
        // case REPAIRING = 'repairing';

        // The technician is currently diagnosing/repairing the device.
    case InRepair = 'in_repair';

        // The technician has determined that parts are needed to repair the device and is waiting for them to arrive.
        // case PENDING_PARTS = 'pending_parts';

        // The technician has determined that parts are needed to repair the device and is waiting for them to arrive.
        // Or waiting for the customer to approve the repair.
    case OnHold = 'on_hold';

        // The repair work is complete and the device is ready to pick up.
    case Fixed = 'fixed';

        // The device cannot be repaired and will be returned to the customer.
    case Defect = 'defect';

        // The device has been returned to the customer.
    case CheckedOut = 'checked_out';

    // METHODS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get list of completed enum cases.
     */
    public static function completedCases(): array
    {
        return [
            self::Fixed,
            self::Defect,
            self::CheckedOut,
        ];
    }

    /**
     * Get the status for the given device.
     */
    public static function fromModel(Device $device): self
    {
        // get the ticket related counters
        $inProgressTicketsCount = $device->inprogress_tickets_count;
        $onHoldTicketsCount = $device->onhold_tickets_count;
        $resolvedTicketsCount = $device->resolved_tickets_count;
        $closedTicketsCount = $device->closed_tickets_count;
        $totalTicketsCount = $device->total_tickets_count;

        // define completed and pending tickets count
        $completedTicketsCount = $resolvedTicketsCount + $closedTicketsCount;
        $pendingTicketsCount = $totalTicketsCount - $completedTicketsCount;

        // get the boolean flags
        $hasTickets = $totalTicketsCount > 0;
        $hasPendingTickets = $pendingTicketsCount > 0;

        // -------------------- TICKET STATES
        // - new                        -> pending
        // - in_progress                -> pending
        // - on_hold                    -> pending
        // - resolved                   -> completed
        // - closed                     -> completed

        // --------------------- DEVICE STATES
        // - checked_in
        // - in_repair
        // - on_hold
        // - fixed
        // - defect
        // - checked_out

        // When a new ticket is created, the device state can remain the same.
        // When a ticket is in progress, the device state can remain the same.
        // When a ticket is put on hold, the device state can be changed to "on_hold".
        // When a ticket is resolved, the device state can remain the same.
        // When a ticket is closed, the device state can be changed to "fixed" if there are no other pending tickets for the device.
        // Overall, the device state can only move to "on_hold" or "in_repair" when there is at least one pending ticket for the device.

        switch ($device->status) {
            case self::CheckedIn:
            case self::OnHold:
                // if the device has pending tickets, it is still in repair and needs further action
                if ($hasPendingTickets) {
                    return self::InRepair;
                }
                // if the device has tickets but no more pending tickets and no tickets in progress,
                // it means that all tickets are completed (resolved / closed), so the device is now fixed
                if ($hasTickets && !$hasPendingTickets && !$inProgressTicketsCount) {
                    return self::Fixed;
                }
                break;

            case self::InRepair:
                // if the device has no tickets or all tickets are on hold,
                // it means that there is nothing left to do for now, so the device is put on hold
                if (!$hasTickets || $hasPendingTickets && !$inProgressTicketsCount) {
                    return self::OnHold;
                }
                // if the device has tickets but no pending tickets or tickets on-hold,
                // it means that all tickets are completed, so the device is now fixed
                if ($hasTickets && !$hasPendingTickets && !$onHoldTicketsCount) {
                    return self::Fixed;
                }
                break;

            case self::Fixed:
            case self::Defect:
            case self::CheckedOut:
                // if the device has no tickets or all tickets are on-hold,
                // it means that there is nothing left to do for now, so the device is put on hold
                if (!$hasTickets || $hasPendingTickets && !$inProgressTicketsCount) {
                    return self::OnHold;
                }
                // if the device has pending tickets or tickets in progress, it means that there are still
                // tickets left to do, so the device is still in progress and needs further action
                if ($hasPendingTickets && $inProgressTicketsCount) {
                    return self::InRepair;
                }
                break;
        }

        return $device->status;
    }
}
