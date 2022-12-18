<?php

namespace Flavorly\VanillaComponents\Core\Confirmation\Concerns;

use Closure;

trait CanBeRaw
{
    protected bool|Closure $isRaw = false;

    public function raw(bool|Closure $condition = true): static
    {
        $this->isRaw = $condition;

        return $this;
    }

    protected function isRaw(): bool
    {
        return $this->evaluate($this->isRaw);
    }

    protected function isSafe(): bool
    {
        return ! $this->isRaw();
    }
}
