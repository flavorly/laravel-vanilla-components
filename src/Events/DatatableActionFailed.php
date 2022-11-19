<?php

namespace Flavorly\VanillaComponents\Events;

use Exception;
use Flavorly\VanillaComponents\Datatables\Actions\Action;
use Flavorly\VanillaComponents\Datatables\Http\Payload\RequestPayload;

class DatatableActionFailed extends BaseEvent
{
    protected ?Exception $exception = null;

    public function __construct(RequestPayload $data, Action $action, Exception $exception = null)
    {
        parent::__construct($data, $action);
        $this->exception = $exception;
    }
}
