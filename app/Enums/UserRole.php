<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum UserRole: string
{
    use HasValues;

    case EXPERT = 'expert';
    case ADMIN = 'admin';
}
