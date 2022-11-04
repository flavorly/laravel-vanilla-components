<?php

namespace VanillaComponents\Datatables\Columns\Concerns;

use Closure;

trait CanBeRaw
{
    protected bool | Closure $isRaw = false;

    public function raw(bool | Closure $condition = true): static
    {
        $this->isRaw = $condition;

        return $this;
    }

    public function isRaw(): bool
    {
        if ($this->evaluate($this->isRaw)) {
            return true;
        }

        return ! $this->evaluate($this->isRaw);
    }

    public function isSafe(): bool
    {
        return ! $this->isRaw();
    }
}
