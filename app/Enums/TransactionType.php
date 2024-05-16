<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum TransactionType: string
{
    use HasValues;

    case Payment = 'payment';
    case Discount = 'discount';
    case Warranty = 'warranty';
    case Refund = 'refund';
}
