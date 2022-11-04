<?php

namespace VanillaComponents\Datatables\Options\Page\Concerns;

use Closure;

trait CanBeDefault
{
    protected bool|Closure $isDefault = false;

    public function default(bool | Closure $condition = true): static
    {
        $this->isDefault = $condition;
        return $this;
    }

    public function isDefault(): bool
    {
        return $this->evaluate($this->isDefault);
    }
}
