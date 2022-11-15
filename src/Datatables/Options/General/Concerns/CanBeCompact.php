<?php

namespace Flavorly\VanillaComponents\Datatables\Options\General\Concerns;

use Closure;

trait CanBeCompact
{
    protected bool | Closure $isCompact = false;

    public function compact(bool | Closure $condition = true): static
    {
        $this->isCompact = $condition;

        return $this;
    }

    public function isCompact(): bool
    {
        return $this->evaluate($this->isCompact);
    }
}
