<?php

namespace VanillaComponents\Core\Components\Concerns;

trait CanBeAligned
{
    protected mixed $align = 'left-top';

    public function align(mixed $condition = null): static
    {
        $this->align = $condition;
        return $this;
    }

    public function getAlign(): mixed
    {
        return $this->evaluate($this->align);
    }

}
