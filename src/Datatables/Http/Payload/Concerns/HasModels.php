<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

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
        return !is_null($this->models) && !$this->models->isEmpty();
    }

    public function getModels(): ?Collection
    {
        return $this->models ?? Collection::make();
    }

    public function resolveModels(): void
    {
        if(
            $this->hasQuery() &&
            ($this->getAction()->shouldConvertToModelsIfWasTypeHinted() && $this->getAction()->getModelPrimaryKey()) &&
            ($this->hasSelectedRows() || $this->isAllSelected())
        ){
            $primaryKey = $this->getAction()->getModelPrimaryKey() ?? $this->getQuery()->getModel()->getKeyName();

            if(empty($primaryKey)){
                throw new \Exception('Unable to resolve model primary key for loading models for this action');
            }

            $this
                ->withModels(
                    $this
                        ->getQuery()
                        ->clone()
                        ->whereIn(
                            $primaryKey,
                            $this->getSelectedRowsIds()
                        )
                        ->get() ?? Collection::make()
                );
        }
    }
}
