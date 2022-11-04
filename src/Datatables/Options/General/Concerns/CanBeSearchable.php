<?php

namespace VanillaComponents\Datatables\Options\General\Concerns;

use Closure;

trait CanBeSearchable
{
    protected bool | Closure $isSearchable = true;

    public function searchable(bool | Closure $condition = true): static
    {
        $this->isSearchable = $condition;

        return $this;
    }

    public function isSearchable(): bool
    {
        return $this->evaluate($this->isSearchable);
    }
}
