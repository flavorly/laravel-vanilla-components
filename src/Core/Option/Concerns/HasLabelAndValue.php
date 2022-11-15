<?php

namespace Flavorly\VanillaComponents\Core\Option\Concerns;

trait HasLabelAndValue
{
    protected string $labelKey = 'text';

    protected string $valueKey = 'value';

    protected string $separatorKey = 'separator';

    protected mixed $label = null;

    protected mixed $value = null;

    public function label(mixed $condition = ''): static
    {
        $this->label = $condition;

        return $this;
    }

    public function value(mixed $condition): static
    {
        $this->value = $condition;
        if (is_array($this->getValue()) && is_a($this, HasChildren::class)) {
            $this->children($this->getValue());
            $this->label($this->getLabel());
            $this->value = $this->separatorKey;
        }

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->evaluate($this->value);
    }

    public function getLabel(): mixed
    {
        return $this->evaluate($this->label);
    }
}
