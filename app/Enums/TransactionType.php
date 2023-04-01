<?php

namespace App\Enums;

class TransactionType extends Enum
{
    const PAYMENT = 'payment';
    const DISCOUNT = 'discount';
    const WARRANTY = 'warranty';
    const REFUND = 'refund';
}
