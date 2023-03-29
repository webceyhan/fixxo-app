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
        // skip if status was manually set
        if ($ticket->isDirty('status')) return;

        $ticket->status = $this->guessTicketStatus($ticket);
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
     * Guess ticket status based on its tasks.
     */
    private function guessTicketStatus(Ticket $ticket): string
    {
        $totalTasksCount = $ticket->total_tasks_count;
        $completedTasksCount = $ticket->completed_tasks_count;
        $pendingTasksCount = $totalTasksCount - $completedTasksCount;

        $hasTasks = $totalTasksCount > 0;
        $hasPendingTasks = $pendingTasksCount > 0;

        switch ($ticket->status) {
            case TicketStatus::NEW:
            case TicketStatus::ON_HOLD:
                // if ticket has pending tasks, it's in progress
                if ($hasPendingTasks) return TicketStatus::IN_PROGRESS;
                // if ticket has tasks but no pending, it's resolved
                if ($hasTasks) return TicketStatus::RESOLVED;
                break;

            case TicketStatus::IN_PROGRESS:
                // if ticket has no tasks, it's on hold
                if (!$hasTasks) return TicketStatus::ON_HOLD;
                // if ticket has tasks but no pending, it's resolved
                if (!$hasPendingTasks) return TicketStatus::RESOLVED;
                break;

            case TicketStatus::RESOLVED:
            case TicketStatus::CLOSED:
                // if ticket has no tasks, it's on hold
                if (!$hasTasks) return TicketStatus::ON_HOLD;
                // if ticket has pending tasks, it's in progress
                if ($hasPendingTasks) return TicketStatus::IN_PROGRESS;
                break;
        }

        return $ticket->status;
    }
}
