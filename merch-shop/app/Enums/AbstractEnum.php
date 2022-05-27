<?php

namespace App\Enums;

use ReflectionClass;

<<<<<<< HEAD
abstract class AbstractEnum
=======
class AbstractEnum
>>>>>>> Lesson 8: Add products and attributes (web & api)
{
    public static function getConstants(){
        return (new ReflectionClass(static::class))->getConstants();
    }
}
