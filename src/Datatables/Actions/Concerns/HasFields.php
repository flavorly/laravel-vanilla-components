<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;

trait HasFields
{
    protected array|Closure $fields = [];

    public function fields(array $fields): static
    {
        $this->fields = $fields;

        return $this;
    }

    public function getFields(): array
    {
        return $this->evaluate($this->fields);
    }
}
