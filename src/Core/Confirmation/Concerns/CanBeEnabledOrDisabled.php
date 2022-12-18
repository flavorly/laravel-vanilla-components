<?php

namespace Flavorly\VanillaComponents\Core\Confirmation\Concerns;

use Closure;

trait CanBeEnabledOrDisabled
{
    protected bool|Closure $isEnabled = true;

    public function enabled(bool|Closure $condition = true): static
    {
        $this->isEnabled = $condition;

        return $this;
    }

    protected function isEnabled(): bool
    {
        return $this->evaluate($this->isEnabled);
    }
}
