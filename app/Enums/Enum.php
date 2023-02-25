<?php

namespace App\Enums;

use Exception;
use ReflectionClass;

class Enum
{
    public static function keys()
    {
        return array_keys(static::constants());
    }

    private static function constants()
    {
        try {
            return (new ReflectionClass(static::class))->getConstants();
        } catch (Exception $e) {
        }
    }

    public static function values()
    {
        return array_values(static::constants());
    }
}
