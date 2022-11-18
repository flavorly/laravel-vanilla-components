<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

trait CanBeConvertedToModels
{
    protected ?string $modelPrimaryKey = null;

    public function convertToModels(string|null $primaryKey = 'id'): static
    {
        $this->modelPrimaryKey = $primaryKey;
        return $this;
    }

    protected function shouldConvertToModelsIfWasTypeHinted(): bool
    {
        $reflection = new \ReflectionFunction($this->executeUsing);
        rd($reflection);
    }

    protected function shouldConvertIDsToModels(): bool
    {



        return $this->evaluate($this->modelPrimaryKey) !== null;
    }

    protected function getModelsPrimaryKey(): string|null
    {
        return $this->evaluate($this->modelPrimaryKey);
    }
}
