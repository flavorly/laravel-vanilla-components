<?php

namespace Flavorly\VanillaComponents\Events;

use Exception;
use Flavorly\VanillaComponents\Datatables\Actions\Action;
use Flavorly\VanillaComponents\Datatables\Data\DatatableRequest;

class DatatableActionFailed extends BaseEvent
{
    protected ?Exception $exception = null;

    public function __construct(DatatableRequest $data, Action $action, Exception $exception = null)
    {
        parent::__construct($data, $action);
        $this->exception = $exception;
    }
}
