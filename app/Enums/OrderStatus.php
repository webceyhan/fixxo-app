<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;

enum OrderStatus: string
{
    use HasBase;

        // The order has been created and is awaiting processing.
    case NEW = 'new';

        // The order has been shipped to the customer.
    case SHIPPED = 'shipped';

        // The order has been received by the customer.
    case RECEIVED = 'received';

        // The order has been cancelled by the customer or by the system.
    case CANCELLED = 'cancelled';
}
