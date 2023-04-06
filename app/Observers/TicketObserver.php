<?php

namespace App\Observers;

use App\Models\Ticket;

class TicketObserver
{
    /**
     * Handle the Ticket "saving" event.
     */
    public function saving(Ticket $ticket): void
    {
        // calculate ticket status if not manually set
        $ticket->isDirty('status') || $ticket->calculateStatus();
    }

    /**
     * Handle the Ticket "creating" event.
     */
    public function creating(Ticket $ticket): void
    {
        // set customer_id automatically
        $ticket->customer_id = $ticket->device->customer_id;
    }

    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        $device = $ticket->device;

        // update device's ticket counters accordingly
        $device->calculateTicketCounters();

        $device->save();
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        $device = $ticket->device;

        // update device's ticket counters if applicable
        if ($ticket->wasChanged('status')) {
            $device->calculateTicketCounters();
        }

        $device->isDirty() && $device->save();
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        $device = $ticket->device;

        // update device's ticket counters accordingly
        $device->calculateTicketCounters();

        $device->save();
    }
}
