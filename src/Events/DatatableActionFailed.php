<?php

namespace VanillaComponents\Events;

use Exception;
use Illuminate\Support\Collection;
use VanillaComponents\Datatables\Actions\Action;

class DatatableActionFailed extends BaseEvent
{
    protected ?Exception $exception = null;

    public function __construct(Action $action, Collection $ids = null, Exception $exception = null)
    {
        parent::__construct($action, $ids);
        $this->exception = $exception;
    }
}
