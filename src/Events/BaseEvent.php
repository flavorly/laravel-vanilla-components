<?php

namespace VanillaComponents\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use VanillaComponents\Datatables\PendingAction\PendingAction;

class BaseEvent
{
    use Dispatchable, SerializesModels;

    protected ?PendingAction $pendingAction = null;

    public function __construct(PendingAction $pendingAction)
    {
        $this->pendingAction = $pendingAction;
    }
}
