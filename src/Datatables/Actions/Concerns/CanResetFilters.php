<?php

namespace VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Illuminate\Support\Arr;

trait CanResetFilters
{
    public function clearFilters(bool | Closure $clear = false): static
    {
        $this->after['resetFilters'] = $this->evaluate($clear);

        return $this;
    }

    protected function getShouldClearFiltersAfterAction(): bool
    {
        return $this->evaluate(Arr::get($this->after, 'resetFilters', true));
    }
}
