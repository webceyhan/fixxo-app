<?php

namespace App\Enums;

class TicketStatus extends Enum
{
    // The ticket has been created but has not yet been assigned to anyone for resolution.
    const OPEN = 'open';

    // The ticket has been assigned to someone and work is underway to resolve the issue.
    const IN_PROGRESS = 'in_progress';

    // The ticket cannot be worked on at the moment, for example, if waiting on a response from the customer or another team.
    const ON_HOLD = 'on_hold';

    // The issue has been resolved and the ticket is awaiting confirmation from the customer.
    const RESOLVED = 'resolved';

    // The ticket has been confirmed as resolved and is now closed.
    const CLOSED = 'closed';
}
