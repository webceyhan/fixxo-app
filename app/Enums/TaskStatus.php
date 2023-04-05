<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;

enum TaskStatus: string
{
    use HasBase;

    case PENDING = 'pending';
    case COMPLETED = 'completed';
}
