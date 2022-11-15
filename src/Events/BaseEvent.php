<?php

namespace Flavorly\VanillaComponents\Events;

use Flavorly\VanillaComponents\Datatables\PendingAction\PendingAction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BaseEvent
{
    use Dispatchable, SerializesModels;

    protected ?PendingAction $pendingAction = null;

    public function __construct(PendingAction $pendingAction)
    {
        $this->pendingAction = $pendingAction;
    }
}
