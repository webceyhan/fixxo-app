<?php

namespace App\Enums;

class OrderStatus extends Enum
{
    // The order has been created and is awaiting processing.
    const NEW = 'new';

    // The order has been shipped to the customer.
    const SHIPPED = 'shipped';

    // The order has been received by the customer.
    const RECEIVED = 'received';

    // The order has been cancelled by the customer or by the system.
    const CANCELLED = 'cancelled';
}
