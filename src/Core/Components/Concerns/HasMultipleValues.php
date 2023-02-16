<?php

namespace Flavorly\VanillaComponents\Core\Components\Concerns;

use Closure;

trait HasMultipleValues
{
    protected bool|Closure $isMultiple = false;

    public function multiple(Closure|bool $condition = true): static
    {
        $this->isMultiple = $condition;

        return $this;
    }

    public function getIsMultiple(): bool
    {
        return $this->evaluate($this->isMultiple);
    }
}
