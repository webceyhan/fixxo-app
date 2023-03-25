<?php

namespace App\Enums;

class DeviceStatus extends Enum
{
    // The device has been brought in for repair and is waiting to be checked by a technician.
    const CHECKED_IN = 'checked_in';

    // The technician is currently diagnosing the problem with the device.
    const DIAGNOSING = 'diagnosing';

    // The technician has determined that parts are needed to repair the device and is waiting for them to arrive.
    const PENDING_PARTS = 'pending_parts';

    // The technician is currently repairing the device.
    const REPAIRING = 'repairing';

    // The repair work is complete and the device is ready to pick up.
    const FIXED = 'fixed';

    // The device cannot be repaired and will be returned to the customer.
    const UNFIXABLE = 'unfixable';

    // The device has been returned to the customer.
    const CHECKED_OUT = 'checked_out';
}
