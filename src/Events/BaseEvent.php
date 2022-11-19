<?php

namespace Flavorly\VanillaComponents\Events;

use Flavorly\VanillaComponents\Datatables\Actions\Action;
use Flavorly\VanillaComponents\Datatables\Data\DatatableRequest;
use Flavorly\VanillaComponents\Datatables\Http\Payload\RequestPayload;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BaseEvent
{
    use Dispatchable, SerializesModels;

    protected ?RequestPayload $data;

    protected ?Action $action;

    public function __construct(RequestPayload $data, Action $action)
    {
        $this->data = $data;
        $this->action = $action;
    }
}
