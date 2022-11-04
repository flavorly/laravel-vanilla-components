<?php

namespace VanillaComponents\Core\Confirmation\Concerns;

use Closure;

trait HasSubtitle
{
    protected string | Closure $subtitle = '';

    public function subtitle(string | Closure $title): static
    {
        $this->subtitle = $title;

        return $this;
    }

    public function getSubtitle(): string
    {
        return $this->evaluate($this->subtitle);
    }
}
