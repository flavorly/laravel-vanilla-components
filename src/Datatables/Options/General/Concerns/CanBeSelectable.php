<?php

namespace Flavorly\VanillaComponents\Datatables\Options\General\Concerns;

use Closure;

trait CanBeSelectable
{
    protected bool $isSelectable = true;

    protected bool $isAllSelectable = true;

    public function selectable(bool | Closure $condition = true, bool | Closure $allowSelectAll = true): static
    {
        $this->isSelectable = $condition;
        $this->isAllSelectable = $allowSelectAll;

        return $this;
    }

    public function canSelectAllMatching(bool | Closure $condition = true): static
    {
        $this->isAllSelectable = $condition;

        return $this;
    }

    public function isSelectable(): bool
    {
        return $this->evaluate($this->isSelectable);
    }

    public function isAllSelectable(): bool
    {
        return $this->evaluate($this->isAllSelectable);
    }
}
