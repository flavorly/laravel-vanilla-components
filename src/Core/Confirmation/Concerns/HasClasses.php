<?php

namespace Flavorly\VanillaComponents\Core\Confirmation\Concerns;

use Closure;

trait HasClasses
{
    protected array | Closure $classes = [
        'title' => '',
        'subtitle' => '',
        'text' => '',
    ];

    public function classes(array | Closure $classes): static
    {
        $this->classes = $classes;

        return $this;
    }

    protected function getClasses(): array
    {
        return $this->evaluate($this->classes);
    }
}
