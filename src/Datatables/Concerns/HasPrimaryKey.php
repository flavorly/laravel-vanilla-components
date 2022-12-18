<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

trait HasPrimaryKey
{
    protected ?string $primaryKey = null;

    public function primaryKey(): ?string
    {
        return $this->getQuery()?->getModel()->getKeyName();
    }

    public function setupPrimaryKey(): void
    {
        $this->primaryKey = $this->primaryKey();
    }

    public function getPrimaryKey(): string
    {
        return $this->primaryKey ?? $this->primaryKey() ?? 'id';
    }
}
