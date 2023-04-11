<?php

namespace App\Enums\Traits;

trait HasKeys
{
    public static function keys(): array
    {
        return array_column(static::cases(), 'name');
    }
}
