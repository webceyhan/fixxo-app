<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum DeviceType: string
{
    use HasValues;

    case Desktop = 'desktop';
    case Laptop = 'laptop';
    case Tablet = 'tablet';
    case Phone = 'phone';
    case Console = 'console';
    case Printer = 'printer';
    case Navigator = 'navigator';
    case Peripheral = 'peripheral';
    case Other = 'other';
}
