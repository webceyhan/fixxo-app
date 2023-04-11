<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;

enum DeviceType: string
{
    use HasBase;

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
