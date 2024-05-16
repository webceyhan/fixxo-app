<?php

namespace App\Enums;

use App\Enums\Concerns\Completable;
use App\Enums\Concerns\HasValues;

enum OrderStatus: string
{
    use HasValues, Completable;

        // The order has been created and is awaiting processing.
    case New = 'new';

        // The order has been shipped to the customer.
    case Shipped = 'shipped';

        // The order has been received by the customer.
    case Received = 'received';

        // The order has been cancelled by the customer or by the system.
    case Cancelled = 'cancelled';

    // METHODS /////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get list of completed enum cases.
     */
    public static function completedCases(): array
    {
        return [
            self::Received,
            self::Cancelled,
        ];
    }
}
