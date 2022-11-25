<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

use Flavorly\VanillaComponents\Datatables\Exceptions\DatatableUnableToResolveModelPrimaryKeyException;
use Illuminate\Database\Eloquent\Collection;

trait HasModels
{
    protected ?Collection $models;

    public function withModels(Collection $models): static
    {
        $this->models = $models;

        return $this;
    }

    public function hasModels(): bool
    {
        return ! is_null($this->models) && ! $this->models->isEmpty();
    }

    public function getModels(): ?Collection
    {
        return $this->models ?? Collection::make();
    }

    public function resolveModels(): void
    {
        $primaryKey = $this->getAction()->getModelPrimaryKey() ?? $this->getQuery()->getModel()->getKeyName();
        if (
            $this->hasQuery() &&
            ($this->getAction()->shouldConvertToModelsIfWasTypeHinted() && $primaryKey !== null) &&
            ($this->hasSelectedRows() || $this->isAllSelected())
        ) {
            throw_if(empty($primaryKey), new DatatableUnableToResolveModelPrimaryKeyException());

            // Not all selected and not selected rows at all
            if (! $this->isAllSelected() && ! $this->hasSelectedRows()) {
                return;
            }

            $this
                ->withModels(
                    $this
                        ->getQuery()
                        ->clone()
                        ->when(! $this->isAllSelected(), fn ($query) => $query->whereIn($primaryKey, $this->getSelectedRowsIds()))
                        ->get() ?? Collection::make()
                );
        }
    }
}
