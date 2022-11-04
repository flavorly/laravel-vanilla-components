<?php

namespace VanillaComponents\Datatables\Filters\Concerns;

trait HasComponentTypes
{
    protected string $component;

    public function select(): static
    {
        $this->component = 'VanillaSelect';
        return $this;
    }

    public function richSelect(): static
    {
        $this->component = 'VanillaRichSelect';
        return $this;
    }

    public function input(): static
    {
        $this->component = 'VanillaInput';
        return $this;
    }

    public function radio(): static
    {
        $this->component = 'VanillaRadio';
        return $this;
    }

    public function checkbox(): static
    {
        $this->component = 'VanillaCheckbox';
        return $this;
    }

    public function checkboxGroup(): static
    {
        $this->component = 'VanillaCheckboxGroup';
        return $this;
    }

    public function component(string $name): static
    {
        $this->component = $name;

        return $this;
    }

    public function getComponent(): string
    {
        return $this->component;
    }
}
