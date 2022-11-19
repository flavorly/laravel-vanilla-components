<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

use Flavorly\VanillaComponents\Datatables\Actions\Action;

trait HasAction
{
    /**
     * If the user sends a action
     *
     * @var ?Action
     */
    protected ?Action $action;

    public function withAction(Action|string|null $action): static
    {
        if (null === $action) {
            return $this;
        }

        if (is_string($action)) {
            $action = $this->getTable()->getActionByKey($action);
        }

        // If its still string, than its probably a class name
        if (is_string($action)) {
            $action = app($action);
        }

        $action->withData($this);

        $this->action = $action;

        return $this;
    }

    public function hasAction(): bool
    {
        return ! is_null($this->action);
    }

    public function getAction(): ?Action
    {
        return $this->action->withData($this);
    }
}
