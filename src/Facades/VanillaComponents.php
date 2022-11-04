<?php

namespace VanillaComponents\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VanillaComponents\VanillaComponents
 */
class VanillaComponents extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \VanillaComponents\VanillaComponents::class;
    }
}
