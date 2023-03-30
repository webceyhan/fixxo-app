<?php

namespace App\Observers;

use App\Enums\DeviceStatus;
use App\Enums\TicketStatus;
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
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        $device = $ticket->device;

        // update device's pending-tickets-count if applicable
        $isClosed = $ticket->status === TicketStatus::CLOSED;
        $device->closed_tickets_count += $isClosed ? 1 : 0;

        // update device's total-tickets-count
        $device->total_tickets_count++;

        $device->save();
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        $device = $ticket->device;

        // update device's pending-tickets-count if ticket status was changed
        if ($ticket->wasChanged('status')) {
            $isClosed = $ticket->status === TicketStatus::CLOSED;
            $isPreviousClosed = $ticket->getOriginal('status') === TicketStatus::CLOSED;
            $device->closed_tickets_count -= $isPreviousClosed ? 1 : 0; // reset previous value
            $device->closed_tickets_count += $isClosed ? 1 : 0; // update with new value
        }

        $device->isDirty() && $device->save();
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        $device = $ticket->device;

        // update device's pending-tickets-count if applicable
        $isClosed = $ticket->status === TicketStatus::CLOSED;
        $device->closed_tickets_count -= $isClosed ? 1 : 0;

        // update device's total-tickets-count
        $device->total_tickets_count--;

        $device->save();
    }
}
