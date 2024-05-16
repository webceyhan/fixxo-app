<?php

namespace App\Enums;

use App\Enums\Concerns\Completable;
use App\Enums\Concerns\HasValues;
use App\Models\Device;

enum DeviceStatus: string
{
    use HasValues, Completable;
    /**
     * Represents a device that has been checked in and is awaiting repair.
     * @default
     */
    case CheckedIn = 'checked_in';

    /**
     * Represents a device that is currently on hold due to pending approval or parts.
     */
    case OnHold = 'on_hold';

    /**
     * Represents a device that is currently being repaired by a technician.
     */
    case InRepair = 'in_repair';

    /**
     * Represents that the repair work has been completed, ready to picked up.
     */
    case Finished = 'finished';

    /**
     * Represents a device that has been returned to the customer.
     */
    case CheckedOut = 'checked_out';

    // METHODS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get list of completed enum cases.
     */
    public static function completedCases(): array
    {
        return [
            self::Finished,
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
        // - finished
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
                    return self::Finished;
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
                    return self::Finished;
                }
                break;

            case self::Finished:
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
