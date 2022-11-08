<?php

namespace VanillaComponents\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use VanillaComponents\Datatables\Actions\Action;

class BaseEvent
{
    use Dispatchable, SerializesModels;

    protected ?Action $action = null;

    protected ?Collection $ids = null;

    public function __construct(Action $action, Collection $ids = null)
    {
        ray('BaseEvent', $action, $ids);
        $this->action = $action;
        $this->ids = $ids;
    }
}
