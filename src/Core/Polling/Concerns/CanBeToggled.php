<?php

namespace Flavorly\VanillaComponents\Core\Polling\Concerns;

use Closure;

trait CanBeToggled
{
    protected bool | Closure $isEnabled = false;

    public function enabled(bool | Closure $condition = true): static
    {
        $this->isEnabled = $condition;

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->evaluate($this->isEnabled);
    }
}
