<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum TransactionMethod: string
{
    use HasValues;

    case Cash = 'cash';
    case Card = 'card';
    case Online = 'online';
}
