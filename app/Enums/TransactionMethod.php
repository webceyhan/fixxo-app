<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;

enum TransactionMethod: string
{
    use HasBase;

    case CASH = 'cash';
    case CARD = 'card';
    case ONLINE = 'online';
}
