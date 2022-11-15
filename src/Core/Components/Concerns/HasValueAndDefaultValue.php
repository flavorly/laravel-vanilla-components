<?php

namespace Flavorly\VanillaComponents\Core\Components\Concerns;

trait HasValueAndDefaultValue
{
    protected mixed $value = null;

    protected mixed $defaultValue = null;

    public function value(mixed $condition = null): static
    {
        $this->value = $condition;

        return $this;
    }

    public function defaultValue(mixed $condition = null): static
    {
        $this->defaultValue = $condition;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->evaluate($this->value);
    }

    public function getDefaultValue(): mixed
    {
        return $this->evaluate($this->defaultValue);
    }
}
