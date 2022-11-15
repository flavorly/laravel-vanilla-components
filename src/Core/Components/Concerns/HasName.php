<?php

namespace Flavorly\VanillaComponents\Core\Components\Concerns;

use Closure;

trait HasName
{
    protected string|null|Closure $name = null;

    public function name(string|null|Closure $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string|null
    {
        return $this->evaluate($this->name);
    }
}
