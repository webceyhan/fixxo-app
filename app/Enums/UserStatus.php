<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum UserStatus: string
{
    use HasValues;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
