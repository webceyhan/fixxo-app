<?php

namespace App\Observers;

use App\Models\Device;

class DeviceObserver
{
    /**
     * Handle the Device "created" event.
     */
    public function created(Device $device): void
    {
        // TODO: add log when checking in a device
    }

    /**
     * Handle the Device "updated" event.
     */
    public function updated(Device $device): void
    {
        // log if device status was changed
        if ($device->isDirty('status')) {
            $device->logs()->create([
                'user_id' => auth()->id(),
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
