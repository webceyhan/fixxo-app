<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum TransactionType: string
{
    use HasValues;

    case PAYMENT = 'payment';
    case DISCOUNT = 'discount';
    case WARRANTY = 'warranty';
    case REFUND = 'refund';
}
