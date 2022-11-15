<?php

namespace Flavorly\VanillaComponents\Events;

use Exception;
use Flavorly\VanillaComponents\Datatables\PendingAction\PendingAction;

class DatatableActionFailed extends BaseEvent
{
    protected ?Exception $exception = null;

    public function __construct(PendingAction $pendingAction, Exception $exception = null)
    {
        parent::__construct($pendingAction);
        $this->exception = $exception;
    }
}
