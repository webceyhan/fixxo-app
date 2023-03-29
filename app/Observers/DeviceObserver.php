<?php

namespace App\Observers;

use App\Enums\DeviceStatus;
use App\Models\Device;

class DeviceObserver
{
    /**
     * Handle the Device "saving" event.
     */
    public function saving(Device $device): void
    {
        // skip if status was manually set
        if ($device->isDirty('status')) return;

        $device->status = $this->guessDeviceStatus($device);
    }

    /**
     * Handle the Device "created" event.
     */
    public function created(Device $device): void
    {
        //
    }

    /**
     * Handle the Device "updated" event.
     */
    public function updated(Device $device): void
    {
        // log if device status was changed
        if ($device->isDirty('status')) {
            $device->logs()->create([
                // use device user if no auth user is available
                'user_id' => auth()->id() ?? $device->user_id,
                'status' => $device->status,
            ]);
        }
    }

    /**
     * Handle the Device "deleted" event.
     */
    public function deleted(Device $device): void
    {
        //
    }

    /**
     * Guess device status based on its tickets.
     */
    private function guessDeviceStatus(Device $device): string
    {
        $totalTicketsCount = $device->total_tickets_count;
        $closedTicketsCount = $device->closed_tickets_count;
        $pendingTicketsCount = $totalTicketsCount - $closedTicketsCount;

        $hasTickets = $totalTicketsCount > 0;
        $hasPendingTickets = $pendingTicketsCount > 0;

        switch ($device->status) {
            case DeviceStatus::CHECKED_IN:
            case DeviceStatus::ON_HOLD:
                // if device has pending tickets, it's in-repair
                if ($hasPendingTickets) return DeviceStatus::IN_REPAIR;
                // if device has tickets but no pending, it's fixed
                if ($hasTickets) return DeviceStatus::FIXED;
                break;

            case DeviceStatus::IN_REPAIR:
                // if device has no tickets, it's on-hold
                if (!$hasTickets) return DeviceStatus::ON_HOLD;
                // if device has tickets but no pending, it's fixed
                if (!$hasPendingTickets) return DeviceStatus::FIXED;
                break;

            case DeviceStatus::FIXED;
            case DeviceStatus::CHECKED_OUT:
                // if device has no tickets, it's on-hold
                if (!$hasTickets) return DeviceStatus::ON_HOLD;
                // if device has pending tickets, it's in-repair
                if ($hasPendingTickets) return DeviceStatus::IN_REPAIR;
                break;
        }

        return $device->status;
    }
}
