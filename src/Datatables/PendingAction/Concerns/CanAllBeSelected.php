<?php

namespace VanillaComponents\Datatables\PendingAction\Concerns;

use Closure;

trait CanAllBeSelected
{
    protected null|bool|Closure $isAllSelected = false;

    public function allSelectedWhen(bool | Closure $allSelected): static
    {
        $this->isAllSelected = $allSelected;

        return $this;
    }

    public function isAllSelected(): bool
    {
        return $this->evaluate($this->isAllSelected);
    }
}
