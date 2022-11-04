<?php

namespace VanillaComponents\Core\Confirmation\Concerns;

use Closure;

trait HasText
{
    protected string | Closure $text = '';

    public function text(string | Closure $title): static
    {
        $this->text = $title;

        return $this;
    }

    public function getText(): string
    {
        return $this->evaluate($this->text);
    }
}
