<?php

namespace App\Enums;

class TaskStatus extends Enum
{
    // TODO: add more declarative statuses
    // or replace it with a completed_at timestamp
    const PENDING = 'pending';
    const DONE = 'done';
}
