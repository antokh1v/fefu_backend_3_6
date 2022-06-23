<?php

namespace App\Enums;

use ReflectionClass;

abstract class AbstractEnum
{
    public static function getConstants(){
        return (new ReflectionClass(static::class))->getConstants();
    }

    public static function keyToValue($key)
    {
        return self::getConstants()[strtoupper($key)] ?? null;
    }

    public static function keyByValue($val): bool|int|string
    {
        return array_search($val, self::getConstants(), true);
    }
}
