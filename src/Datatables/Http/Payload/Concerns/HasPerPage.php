<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

trait HasPerPage
{
    /**
     * Stores the per page
     */
    protected int $perPage = 10;

    public function withPerPage(?int $perPage): static
    {
        if (null !== $perPage && $this->getTable() !== null) {
            $this->perPage = $this->getTable()->getPerPageOptionByNumber($perPage)->getValue() ?? 10;
        }

        return $this;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function hasPerPage(): bool
    {
        return $this->perPage > 0;
    }
}
