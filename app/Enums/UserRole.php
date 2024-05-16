<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum UserRole: string
{
    use HasValues;

    case Expert = 'expert';
    case Admin = 'admin';
}
