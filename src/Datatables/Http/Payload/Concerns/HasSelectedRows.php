<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

use Illuminate\Support\Collection;

trait HasSelectedRows
{
    /**
     * Stores the selected rows ids/primary keys
     */
    protected Collection $selectedRowsIds;

    public function withSelectedRowsIds(Collection $selectedRowsIds): static
    {
        $this->selectedRowsIds = $selectedRowsIds;

        return $this;
    }

    public function getSelectedRowsIds(): Collection
    {
        return $this->selectedRowsIds;
    }

    public function hasSelectedRows(): bool
    {
        return ! $this->selectedRowsIds->isEmpty();
    }
}
