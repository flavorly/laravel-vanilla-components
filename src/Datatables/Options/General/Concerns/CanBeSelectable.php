<?php

namespace VanillaComponents\Datatables\Options\General\Concerns;

use Closure;

trait CanBeSelectable
{
    protected bool $isSelectable = true;

    public function selectable(bool | Closure $condition = true): static
    {
        $this->isSelectable = $condition;
        return $this;
    }

    public function isSelectable(): bool
    {
        return $this->evaluate($this->isSelectable);
    }
}
