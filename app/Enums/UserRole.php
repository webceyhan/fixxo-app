<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;

enum UserRole: string
{
    use HasBase;

    case EXPERT = 'expert';
    case ADMIN = 'admin';
}
