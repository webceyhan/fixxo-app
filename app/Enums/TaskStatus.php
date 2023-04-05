<?php

namespace App\Enums;

enum TaskStatus: string
{
    use Traits\HasBase;

    case PENDING = 'pending';
    case COMPLETED = 'completed';
}
