<?php

namespace VanillaComponents\Datatables\Table\Concerns;

use VanillaComponents\Datatables\Columns\Column;

trait HasName
{
    protected ?string $name = null;

    public function name(): string
    {
        return uniqid('datatable');
    }

    public function setupName(): void
    {
        $this->name = $this->name();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
