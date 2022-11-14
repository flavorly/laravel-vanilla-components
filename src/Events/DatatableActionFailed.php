<?php

namespace VanillaComponents\Events;

use Exception;
use Illuminate\Support\Collection;
use VanillaComponents\Datatables\Actions\Action;
use VanillaComponents\Datatables\PendingAction\PendingAction;

class DatatableActionFailed extends BaseEvent
{
    protected ?Exception $exception = null;

    public function __construct(PendingAction $pendingAction, Exception $exception = null)
    {
        parent::__construct($pendingAction);
        $this->exception = $exception;
    }
}
