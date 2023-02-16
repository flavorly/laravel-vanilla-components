<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

trait CanSelectAllRows
{
    /**
     * Checks if all is selected
     */
    protected bool $isAllSelected = false;

    public function withIsAllSelected(bool $isAllSelected): static
    {
        $this->isAllSelected = $isAllSelected;

        return $this;
    }

    public function isAllSelected(): bool
    {
        return $this->isAllSelected;
    }

    public function isNotAllSelected(): bool
    {
        return ! $this->isAllSelected;
    }
}
