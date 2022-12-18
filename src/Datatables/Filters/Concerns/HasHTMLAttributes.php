<?php

namespace Flavorly\VanillaComponents\Datatables\Filters\Concerns;

use Closure;

trait HasHTMLAttributes
{
    protected Closure|array $attributes = [];

    public function attributes(array|Closure $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getAttributes(): array
    {
        return collect($this->attributes)
            ->except(['v-model', 'v-bind', 'model-value', '@input', '@change'])
            ->toArray();
    }
}
