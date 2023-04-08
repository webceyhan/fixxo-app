<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;
use App\Models\Ticket;

enum TicketStatus: string
{
    use HasBase;

        // The ticket has been created but has not yet been assigned to anyone for resolution.
    case NEW = 'new';

        // The ticket has been assigned to someone and work is underway to resolve the issue.
    case IN_PROGRESS = 'in_progress';

        // The ticket cannot be worked on at the moment, for example, if waiting on a response from the customer or another team.
    case ON_HOLD = 'on_hold';

        // The issue has been resolved and the ticket is awaiting confirmation from the customer.
    case RESOLVED = 'resolved';

        // The ticket has been confirmed as resolved and is now closed.
    case CLOSED = 'closed';

    /**
     * Get the progress for the ticket status.
     */
    public function progress(): Progress
    {
        return match ($this) {
            self::NEW, self::ON_HOLD => Progress::PENDING,
            self::IN_PROGRESS => Progress::PROCESSING,
            self::RESOLVED, self::CLOSED => Progress::COMPLETED,
        };
    }

    /**
     * Get the status for the given ticket.
     */
    public static function fromModel(Ticket $ticket): self
    {
        // get the task related counters
        $totalTasksCount = $ticket->total_tasks_count;
        $completedTasksCount = $ticket->completed_tasks_count;
        $pendingTasksCount = $totalTasksCount - $completedTasksCount;

        // get the boolean flags
        $hasTasks = $totalTasksCount > 0;
        $hasPendingTasks = $pendingTasksCount > 0;
        $hasPendingOrders = $ticket->pending_orders_count > 0;

        switch ($ticket->status) {
            case self::NEW:
            case self::ON_HOLD:
                // if the ticket has pending tasks, it is still in progress and needs further action
                if ($hasPendingTasks && !$hasPendingOrders) {
                    return self::IN_PROGRESS;
                }
                // if the ticket has no pending tasks but still has tasks, it means that all tasks
                // are completed, so the ticket is now resolved and no further action is needed
                if ($hasTasks && !$hasPendingTasks && !$hasPendingOrders) {
                    return self::RESOLVED;
                }
                break;

            case self::IN_PROGRESS:
                // if the ticket has no tasks, it means that there is nothing left 
                // to do for now, so the ticket is put on hold
                if (!$hasTasks || $hasPendingOrders) {
                    return self::ON_HOLD;
                }
                // if the ticket has tasks but no pending tasks, it means that all tasks are completed, 
                // so the ticket is now resolved and no further action is needed
                if ($hasTasks && !$hasPendingTasks && !$hasPendingOrders) {
                    return self::RESOLVED;
                }
                break;

            case self::RESOLVED:
            case self::CLOSED:
                // if the ticket has no tasks, it means that there is nothing left 
                // to do for now, so the ticket is put on hold
                if (!$hasTasks || $hasPendingOrders) {
                    return self::ON_HOLD;
                }
                // if the ticket has pending tasks, it means that there are still tasks left to do, 
                // so the ticket is still in progress and needs further action
                if ($hasPendingTasks && !$hasPendingOrders) {
                    return self::IN_PROGRESS;
                }
                break;
        }

        return $ticket->status;
    }
}
