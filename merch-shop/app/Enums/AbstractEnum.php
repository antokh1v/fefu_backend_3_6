<?php

namespace App\Enums;

use ReflectionClass;

class AbstractEnum
{
    public static function getConstants(){
        return (new ReflectionClass(static::class))->getConstants();
    }
}
