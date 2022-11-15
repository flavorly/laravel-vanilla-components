<?php

namespace Flavorly\VanillaComponents\Datatables\Options\General\Concerns;

use Closure;

trait CanBeRefreshable
{
    protected bool | Closure $isRefreshable = true;

    public function refreshable(bool | Closure $condition = true): static
    {
        $this->isRefreshable = $condition;

        return $this;
    }

    public function isRefreshable(): bool
    {
        return $this->evaluate($this->isRefreshable);
    }
}
