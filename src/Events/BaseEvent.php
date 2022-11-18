<?php

namespace Flavorly\VanillaComponents\Events;

use Flavorly\VanillaComponents\Datatables\Actions\Action;
use Flavorly\VanillaComponents\Datatables\Data\DatatableRequest;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BaseEvent
{
    use Dispatchable, SerializesModels;

    protected ?DatatableRequest $data;

    protected ?Action $action;

    public function __construct(DatatableRequest $data, Action $action)
    {
        $this->data = $data;
        $this->action = $action;
    }
}
