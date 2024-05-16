<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum OrderStatus: string
{
    use HasValues;

        // The order has been created and is awaiting processing.
    case NEW = 'new';

        // The order has been shipped to the customer.
    case SHIPPED = 'shipped';

        // The order has been received by the customer.
    case RECEIVED = 'received';

        // The order has been cancelled by the customer or by the system.
    case CANCELLED = 'cancelled';

    /**
     * Get the progress for the order status.
     */
    public function progress(): Progress
    {
        return match ($this) {
            self::NEW => Progress::PENDING,
            self::SHIPPED => Progress::PROCESSING,
            self::RECEIVED,
            self::CANCELLED => Progress::COMPLETED,
        };
    }
}
