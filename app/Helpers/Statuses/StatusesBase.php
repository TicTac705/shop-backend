<?php

namespace App\Helpers\Statuses;

use ReflectionClass;

class StatusesBase
{
    static function getConstants(): array
    {
        $oClass = new ReflectionClass(get_called_class());
        return $oClass->getConstants();
    }
}
