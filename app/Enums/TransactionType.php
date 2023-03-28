<?php

namespace App\Enums;

class TransactionType extends Enum
{
    const CHARGE = 'charge';
    const DISCOUNT = 'discount';
    const WARRANTY = 'warranty';
    const REFUND = 'refund';
}
