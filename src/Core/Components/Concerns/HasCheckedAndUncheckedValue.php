<?php

namespace VanillaComponents\Core\Components\Concerns;

trait HasCheckedAndUncheckedValue
{
    protected mixed $checkedValue = null;
    protected mixed $uncheckedValue = null;

    public function checkedValue(mixed $condition = null): static
    {
        $this->checkedValue = $condition;
        return $this;
    }

    public function uncheckedValue(mixed $condition = null): static
    {
        $this->uncheckedValue = $condition;
        return $this;
    }

    public function getCheckedValue(): mixed
    {
        return $this->evaluate($this->checkedValue);
    }

    public function getUncheckedValue(): mixed
    {
        return $this->evaluate($this->uncheckedValue);
    }
}
