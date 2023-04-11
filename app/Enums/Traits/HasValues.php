<?php

namespace App\Enums\Traits;

trait HasValues
{
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }
}
