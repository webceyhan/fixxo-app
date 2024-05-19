<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum TransactionType: string
{
    use HasValues;

    /**
     * Represents a payment transaction.
     * @default
     */
    case Payment = 'payment';

    /**
     * Represents a discount transaction.
     */
    case Discount = 'discount';

    /**
     * Represents a claim transaction such as warranty, insurance, returns, and reimbursements.
     */
    case Claim = 'claim';

    /**
     * Represents a refund transaction.
     */
    case Refund = 'refund';
}
