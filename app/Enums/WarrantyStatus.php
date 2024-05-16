<?php

namespace App\Enums;

use App\Enums\Concerns\HasValues;
use App\Models\Device;

enum WarrantyStatus: string
{
    use HasValues;

        // The device has no purchase date or warranty expire date.
    case NA = 'na';

        // The device has a purchase date and warranty is still valid.
    case Valid = 'valid';

        // The device has a purchase date and warranty has expired.
    case Expired = 'expired';

    public static function fromModel(Device $device): self
    {
        return match ($device->warranty_expire_date?->isPast()) {
            true => self::Expired,
            false => self::Valid,
            default => self::NA,
        };
    }
}
