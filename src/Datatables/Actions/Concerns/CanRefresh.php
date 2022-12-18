<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Illuminate\Support\Arr;

trait CanRefresh
{
    public function refreshAfterExecuted(bool|Closure $refresh = false): static
    {
        $this->after['refresh'] = $this->evaluate($refresh);

        return $this;
    }

    protected function getShouldRefreshAfterExecuted(): bool
    {
        return $this->evaluate(Arr::get($this->after, 'refresh', true));
    }
}
