<?php

namespace Flavorly\VanillaComponents\Datatables\PendingAction\Concerns;

use Flavorly\VanillaComponents\Datatables\Actions\Action;

trait BelongsToAction
{
    protected ?Action $action = null;

    public function action(?Action $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }
}
