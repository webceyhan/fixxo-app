<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;

enum TransactionType: string
{
    use HasBase;

    case PAYMENT = 'payment';
    case DISCOUNT = 'discount';
    case WARRANTY = 'warranty';
    case REFUND = 'refund';
}
