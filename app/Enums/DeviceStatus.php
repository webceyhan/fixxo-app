<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;

enum DeviceStatus: string
{
    use HasBase;

        // The device has been brought in for repair and is waiting to be checked by a technician.
    case CHECKED_IN = 'checked_in';

        // The technician is currently diagnosing the problem with the device.
        // case DIAGNOSING = 'diagnosing';

        // The technician is currently repairing the device.
        // case REPAIRING = 'repairing';

        // The technician is currently diagnosing/repairing the device.
    case IN_REPAIR = 'in_repair';

        // The technician has determined that parts are needed to repair the device and is waiting for them to arrive.
        // case PENDING_PARTS = 'pending_parts';

        // The technician has determined that parts are needed to repair the device and is waiting for them to arrive.
        // Or waiting for the customer to approve the repair.
    case ON_HOLD = 'on_hold';

        // The repair work is complete and the device is ready to pick up.
    case FIXED = 'fixed';

        // The device cannot be repaired and will be returned to the customer.
    case DEFECT = 'defect';

        // The device has been returned to the customer.
    case CHECKED_OUT = 'checked_out';
}
