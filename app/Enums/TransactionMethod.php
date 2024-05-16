<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum TransactionMethod: string
{
    use HasValues;

    case CASH = 'cash';
    case CARD = 'card';
    case ONLINE = 'online';
}
