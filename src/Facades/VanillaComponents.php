<?php

namespace Flavorly\VanillaComponents\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Flavorly\VanillaComponents\VanillaComponents
 */
class VanillaComponents extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Flavorly\VanillaComponents\VanillaComponents::class;
    }
}
