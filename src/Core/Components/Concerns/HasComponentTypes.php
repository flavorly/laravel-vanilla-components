<?php

namespace VanillaComponents\Core\Components\Concerns;

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

    public function textarea(): static
    {
        $this->component = 'VanillaTextarea';

        return $this;
    }

    public function toggle(): static
    {
        $this->component = 'VanillaToggle';

        return $this;
    }

    public function toggleGroup(): static
    {
        $this->component = 'VanillaToggleGroup';

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

    public function datetimeInput(): static
    {
        $this->component = 'VanillaDateTimeInput';

        return $this;
    }

    public function phoneInput(): static
    {
        $this->component = 'VanillaPhoneInput';

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
