<?php

namespace App\Enums;

use ReflectionClass;

abstract class AbstractEnum
{
    public static function getConstants(){
        return (new ReflectionClass(static::class))->getConstants();
    }
}
