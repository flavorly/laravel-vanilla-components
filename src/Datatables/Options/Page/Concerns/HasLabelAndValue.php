<?php

namespace VanillaComponents\Datatables\Options\Page\Concerns;

use Closure;

trait HasLabelAndValue
{
    protected string|null|Closure $label = null;
    protected int|null|Closure $value = 5;

    public function label(string | Closure $condition = ''): static
    {
        $this->label = $condition;
        return $this;
    }

    public function value(int  | Closure $condition = 5): static
    {
        $this->value = $condition;
        return $this;
    }

    public function getValue(): int
    {
        return $this->evaluate($this->value);
    }

    public function getLabel(): string
    {
        return $this->evaluate($this->label);
    }
}
