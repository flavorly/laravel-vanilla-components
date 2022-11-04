<?php

namespace VanillaComponents\Core\Confirmation\Concerns;

use Closure;

trait HasTitle
{
    protected string | Closure $title = '';

    public function title(string | Closure $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->evaluate($this->title);
    }
}
