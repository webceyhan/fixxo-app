<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;
use App\Models\Ticket;

enum TicketStatus: string
{
    use HasValues;

        // The ticket has been created but has not yet been assigned to anyone for resolution.
    case New = 'new';

        // The ticket has been assigned to someone and work is underway to resolve the issue.
    case InProgress = 'in_progress';

        // The ticket cannot be worked on at the moment, for example, if waiting on a response from the customer or another team.
    case OnHold = 'on_hold';

        // The issue has been resolved and the ticket is awaiting confirmation from the customer.
    case Resolved = 'resolved';

        // The ticket has been confirmed as resolved and is now closed.
    case Closed = 'closed';

    /**
     * Get the progress for the ticket status.
     */
    public function progress(): Progress
    {
        return match ($this) {
            self::New, 
            self::OnHold => Progress::Pending,
            self::InProgress => Progress::Processing,
            self::Resolved, 
            self::Closed => Progress::Completed,
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
            case self::New:
            case self::OnHold:
                // if the ticket has pending tasks, it is still in progress and needs further action
                if ($hasPendingTasks && !$hasPendingOrders) {
                    return self::InProgress;
                }
                // if the ticket has no pending tasks but still has tasks, it means that all tasks
                // are completed, so the ticket is now resolved and no further action is needed
                if ($hasTasks && !$hasPendingTasks && !$hasPendingOrders) {
                    return self::Resolved;
                }
                break;

            case self::InProgress:
                // if the ticket has no tasks, it means that there is nothing left 
                // to do for now, so the ticket is put on hold
                if (!$hasTasks || $hasPendingOrders) {
                    return self::OnHold;
                }
                // if the ticket has tasks but no pending tasks, it means that all tasks are completed, 
                // so the ticket is now resolved and no further action is needed
                if ($hasTasks && !$hasPendingTasks && !$hasPendingOrders) {
                    return self::Resolved;
                }
                break;

            case self::Resolved:
            case self::Closed:
                // if the ticket has no tasks, it means that there is nothing left 
                // to do for now, so the ticket is put on hold
                if (!$hasTasks || $hasPendingOrders) {
                    return self::OnHold;
                }
                // if the ticket has pending tasks, it means that there are still tasks left to do, 
                // so the ticket is still in progress and needs further action
                if ($hasPendingTasks && !$hasPendingOrders) {
                    return self::InProgress;
                }
                break;
        }

        return $ticket->status;
    }
}
