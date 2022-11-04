<?php

namespace VanillaComponents\Core\Confirmation\Concerns;

use Closure;

trait CanBeEnabledOrDisabled
{
    protected bool | Closure $isEnabled = false;

    public function enabled(bool | Closure $condition = true): static
    {
        $this->isEnabled = $condition;

        return $this;
    }

    protected function isEnabled(): bool
    {
        return $this->evaluate($this->isEnabled);
    }
}
