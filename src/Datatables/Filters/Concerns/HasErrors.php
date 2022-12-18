<?php

namespace Flavorly\VanillaComponents\Datatables\Filters\Concerns;

use Closure;

trait HasErrors
{
    protected string|Closure|null $errors = null;

    public function errors(string|Closure|null $errors): static
    {
        $this->errors = $errors;

        return $this;
    }

    public function getErrors(): ?string
    {
        return $this->evaluate($this->errors);
    }
}
