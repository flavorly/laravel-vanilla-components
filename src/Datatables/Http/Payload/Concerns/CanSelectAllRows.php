<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

use Illuminate\Support\Collection;

trait CanSelectAllRows
{
    /**
     * Checks if all is selected
     *
     * @var bool
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
        return !$this->isAllSelected;
    }
}
