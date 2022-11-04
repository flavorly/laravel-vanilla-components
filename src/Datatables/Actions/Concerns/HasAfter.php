<?php

namespace VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Illuminate\Support\Arr;
use VanillaComponents\Core\Polling\PollingOptions;

trait HasAfter
{
    protected array | Closure $after = [];

    public function after(array|Closure $after = []): static
    {
        $this->after = $after;
        return $this;
    }

    protected function getAfterToArray(): array
    {
        $result = $this->evaluate($this->after) ?? [];
        return collect($result)
            ->map(function ($value, $key) {
                if ($value instanceof Closure) {
                    return $this->evaluate($value);
                }
                if(is_array($value)) {
                    return $value;
                }

                if(is_object($value) && method_exists($value, 'toArray')) {
                    return $value->toArray();
                }
                return $value;
            })
            ->toArray();
    }
}
