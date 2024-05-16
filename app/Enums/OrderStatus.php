<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum OrderStatus: string
{
    use HasValues;

        // The order has been created and is awaiting processing.
    case New = 'new';

        // The order has been shipped to the customer.
    case Shipped = 'shipped';

        // The order has been received by the customer.
    case Received = 'received';

        // The order has been cancelled by the customer or by the system.
    case Cancelled = 'cancelled';

    /**
     * Get the progress for the order status.
     */
    public function progress(): Progress
    {
        return match ($this) {
            self::New => Progress::Pending,
            self::Shipped => Progress::Processing,
            self::Received,
            self::Cancelled => Progress::Completed,
        };
    }
}
