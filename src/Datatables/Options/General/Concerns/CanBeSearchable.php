<?php

namespace Flavorly\VanillaComponents\Datatables\Options\General\Concerns;

use Closure;

trait CanBeSearchable
{
    protected bool | Closure $isSearchable = true;

    protected bool | Closure $isSearchableHidden = false;

    public function searchable(bool | Closure $condition = true, bool | Closure $hiddenByDefault = false): static
    {
        $this->isSearchable = $condition;
        $this->isSearchableHidden = $hiddenByDefault;

        return $this;
    }

    public function hideSearchBar(bool | Closure $hiddenByDefault = true): static
    {
        $this->isSearchableHidden = $hiddenByDefault;

        return $this;
    }

    public function isSearchable(): bool
    {
        return $this->evaluate($this->isSearchable);
    }

    public function isSearchBarHiddenByDefault(): bool
    {
        return $this->evaluate($this->isSearchableHidden);
    }
}
