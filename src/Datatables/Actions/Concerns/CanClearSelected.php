<?php

namespace VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Illuminate\Support\Arr;

trait CanClearSelected
{
    public function clearSelectionAfterAction(bool | Closure $clear = true): static
    {
        $this->after['clearSelected'] = $this->evaluate($clear);

        return $this;
    }

    public function getShouldClearSelectionAfterAction(): bool
    {
        return $this->evaluate(Arr::get($this->after, 'clearSelected', true));
    }
}
