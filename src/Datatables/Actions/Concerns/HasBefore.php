<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;

trait HasBefore
{
    protected array|Closure $before = [];

    public function before(array|Closure $before = []): static
    {
        $this->before = $before;

        return $this;
    }

    protected function getBeforeToArray(): array
    {
        $result = $this->evaluate($this->before) ?? [];

        return collect($result)
            ->map(function ($value, $key) {
                if ($value instanceof Closure) {
                    return $this->evaluate($value);
                }
                if (is_array($value)) {
                    return $value;
                }

                if (is_object($value) && method_exists($value, 'toArray')) {
                    return $value->toArray();
                }

                return $value;
            })
            ->toArray();
    }
}
