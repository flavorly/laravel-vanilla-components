<?php

namespace Flavorly\VanillaComponents\Core\Components\Concerns;

use Closure;
use Flavorly\VanillaComponents\Core\Option\Option;

trait HasOptions
{
    protected array | Closure $options = [];

    protected string | Closure $optionTextAttribute = 'text';

    protected string | Closure $optionLabelAttribute = 'value';

    public function options(array | Closure $optionsOrClosure): static
    {
        $this->options = Option::make()->fromArray($this->evaluate($optionsOrClosure));

        return $this;
    }

    public function optionTextAttribute(string | Closure $optionTextAttribute): static
    {
        $this->optionTextAttribute = $optionTextAttribute;

        return $this;
    }

    public function optionLabelAttribute(string | Closure $optionLabelAttribute): static
    {
        $this->optionLabelAttribute = $optionLabelAttribute;

        return $this;
    }

    public function getOptionLabelAttribute(): string
    {
        return $this->evaluate($this->optionLabelAttribute);
    }

    public function getOptionValueAttribute(): string
    {
        return $this->evaluate($this->optionLabelAttribute);
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
