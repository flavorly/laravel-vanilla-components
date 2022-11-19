<?php

namespace Flavorly\VanillaComponents\Datatables\Exceptions;

use Exception;

class DatatableUnableToResolveModelPrimaryKeyException extends Exception
{
    public function __construct($additionally = '')
    {
        parent::__construct(sprintf('Action must provide a : using(fn() => ...) callable, or to be a class that implements a handle or invoke method. %s', $additionally));
    }
}
