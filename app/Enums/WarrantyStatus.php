<?php

namespace App\Enums;

use App\Enums\Traits\HasBase;
use App\Models\Device;

enum WarrantyStatus: string
{
    use HasBase;

        // The device has no purchase date or warranty expire date.
    case NA = 'na';

        // The device has a purchase date and warranty is still valid.
    case VALID = 'valid';

        // The device has a purchase date and warranty has expired.
    case EXPIRED = 'expired';

    public static function fromModel(Device $device): self
    {
        return match ($device->warranty_expire_date?->isPast()) {
            true => self::EXPIRED,
            false => self::VALID,
            default => self::NA,
        };
    }
}
