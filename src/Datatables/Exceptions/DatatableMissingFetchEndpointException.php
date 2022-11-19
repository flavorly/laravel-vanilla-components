<?php

namespace Flavorly\VanillaComponents\Datatables\Exceptions;

use Exception;

class DatatableMissingFetchEndpointException extends Exception
{
    public function __construct($additionally = '')
    {
        parent::__construct(sprintf('Fetch endpoint is required. Please define a method with the name fetchEndpoint() in your datatable class and return the full URL/Route for the datatable.. %s', $additionally));
    }
}
