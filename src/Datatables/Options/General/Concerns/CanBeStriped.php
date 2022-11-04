<?php

namespace VanillaComponents\Datatables\Options\General\Concerns;

use Closure;

trait CanBeStriped
{
    protected bool | Closure $isStriped = false;

    public function striped(bool|Closure $condition = true): static
    {
        $this->isStriped = $condition;

        return $this;
    }

    public function isStriped(): bool
    {
        return $this->evaluate($this->isStriped);
    }
}
