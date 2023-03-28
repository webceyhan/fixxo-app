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
        // skip if status was already changed
        if ($ticket->isDirty('status')) return;

        switch ($ticket->status) {
            case TicketStatus::NEW:
            case TicketStatus::RESOLVED:
            case TicketStatus::CLOSED:
                // if there are pending tasks, mark ticket as in-progress
                if ($ticket->pending_task_count > 0) {
                    $ticket->status = TicketStatus::IN_PROGRESS;
                }
                break;

            case TicketStatus::ON_HOLD:
            case TicketStatus::IN_PROGRESS:
                // if there are no pending tasks, mark ticket as resolved
                if ($ticket->pending_task_count === 0) {
                    $ticket->status = TicketStatus::RESOLVED;
                }
                break;
        }
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

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
