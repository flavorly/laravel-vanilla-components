<?php

namespace VanillaComponents\Core\Option\Concerns;

use Closure;

trait CanBeDisabled
{
    protected string $disabledKey = 'disabled';
    protected bool | Closure $isDisabled = false;

    public function disabled(bool|Closure $condition = true): static
    {
        $this->isDisabled = $condition;
        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->evaluate($this->isDisabled);
    }
}
