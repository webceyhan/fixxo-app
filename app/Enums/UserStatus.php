<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;

enum UserStatus: string
{
    use HasBase;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
