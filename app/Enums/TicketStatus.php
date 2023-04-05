<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;

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
}
