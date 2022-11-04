<?php

namespace VanillaComponents\Datatables\Concerns;

use VanillaComponents\Datatables\Datatable;

trait BelongsToTable
{
    protected ?Datatable $table = null;

    public function table(?Datatable $table): static
    {
        $this->table = $table;

        return $this;
    }

    public function getTable(): ?Datatable
    {
        return $this->table;
    }
}
