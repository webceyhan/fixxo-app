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
        //
    }

    /**
     * Handle the Device "updated" event.
     */
    public function updated(Device $device): void
    {
        // log if the status has changed
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

    /**
     * Handle the Device "restored" event.
     */
    public function restored(Device $device): void
    {
        //
    }

    /**
     * Handle the Device "force deleted" event.
     */
    public function forceDeleted(Device $device): void
    {
        //
    }
}
