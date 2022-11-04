<?php

namespace VanillaComponents\Core\Confirmation\Concerns;

use Closure;

trait HasComponent
{
    protected string|Closure|null $component = null;

    public function component(string|Closure $name): static
    {
        $this->component = $name;

        return $this;
    }

    protected function getComponent(): string
    {
        return $this->evaluate($this->component);
    }
}
