<?php

namespace Flavorly\VanillaComponents\Datatables\Filters\Concerns;

use Closure;
use Flavorly\VanillaComponents\Core\Option\Option;

trait HasOptions
{
    protected array|Closure $options = [];

    public function options(array|Closure $optionsOrClosure): static
    {
        $this->options = Option::make()->fromArray($this->evaluate($optionsOrClosure));

        return $this;
    }

    public function getOptions(): array
    {
        return $this->evaluate($this->options);
    }

    public function getOptionsToArray(): array
    {
        $options = $this->getOptions();
        if (! empty($options)) {
            return collect($options)
                ->map(function ($option) {
                    if ($option instanceof Option) {
                        return $option->toArray();
                    }
                    if (is_array($option)) {
                        return $option;
                    }

                    return [];
                })
                ->filter(fn ($option) => $option !== null)
                ->toArray();
        }

        return [];
    }
}
