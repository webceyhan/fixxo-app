<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;

enum DeviceType: string
{
    use HasValues;

    case DESKTOP = 'desktop';
    case LAPTOP = 'laptop';
    case TABLET = 'tablet';
    case PHONE = 'phone';
    case CONSOLE = 'console';
    case PRINTER = 'printer';
    case NAVIGATOR = 'navigator';
    case PERIPHERAL = 'peripheral';
    case OTHER = 'other';
}
