<?php

namespace VanillaComponents\Core\Components\Concerns;

use Closure;
use Illuminate\Support\Str;

trait HasPlaceholder
{
    protected string | Closure | null $placeholder = null;

    public function placeholder(string | Closure | null $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function getPlaceholder(): string | null
    {
        return $this->evaluate($this->placeholder);
    }
}
