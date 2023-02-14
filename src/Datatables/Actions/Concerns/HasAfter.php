<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;

trait HasAfter
{
    protected array|Closure $after = [];

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
                if (is_array($value)) {
                    return $value;
                }

                if (is_object($value) && method_exists($value, 'toArray')) {
                    return $value->toArray();
                }

                return $value;
            })
            ->when($this->getInertia() !== null, function ($collection) {
                return $collection->put('inertia', $this->getInertia()->toArray());
            })
            ->when($this->getRedirectUrl() !== null, function ($collection) {
                return $collection->put('redirect', [
                    'url' => $this->getRedirectUrl(),
                    'newTab' => $this->shouldRedirectToNewTab(),
                ]);
            })
            ->toArray();
    }
}
