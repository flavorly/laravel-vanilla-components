<?php

namespace Flavorly\VanillaComponents\Core\Confirmation\Concerns;

use Closure;

trait HasLevel
{
    protected string|Closure $level = 'info';

    public function level(string|Closure $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function info(): static
    {
        $this->level = 'info';

        return $this;
    }

    public function warning(): static
    {
        $this->level = 'warning';

        return $this;
    }

    public function success(): static
    {
        $this->level = 'success';

        return $this;
    }

    public function danger(): static
    {
        $this->level = 'danger';

        return $this;
    }

    protected function getLevel(): string
    {
        return $this->evaluate($this->level);
    }
}
