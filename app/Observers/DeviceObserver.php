<?php

namespace App\Observers;

use App\Models\Device;

class DeviceObserver
{
    /**
     * Handle the Device "saving" event.
     */
    public function saving(Device $device): void
    {
        // calculate device status if not manually set
        $device->isDirty('status') || $device->hydrateStatus();
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
}
