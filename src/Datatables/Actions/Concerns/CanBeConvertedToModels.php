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

    public function shouldConvertToModelsIfWasTypeHinted(): bool
    {
        ray('Should execute', $this->executeUsing !== null);

        // If the user provided a callback
        if ($this->executeUsing !== null) {
            try {
                $reflection = new \ReflectionFunction($this->executeUsing);
                foreach ($reflection->getParameters() as $parameter) {
                    if (
                        $parameter->getType() === 'Illuminate\Database\Eloquent\Collection' ||
                        $parameter->getName() === 'models'
                    ) {
                        return true;
                    }
                }
            } catch (\ReflectionException $e) {
            }

            return false;
        }

        ray('Going for methods', $this->getDefaultMethodsToCheck());

        foreach ($this->getDefaultMethodsToCheck() as $method) {
            if (method_exists($this, $method)) {
                try {
                    $reflection = new \ReflectionMethod($this, $method);
                    foreach ($reflection->getParameters() as $parameter) {
                        if (
                            $parameter->getType() === 'Illuminate\Database\Eloquent\Collection' ||
                            $parameter->getName() === 'models'
                        ) {
                            return true;
                        }
                    }
                } catch (\ReflectionException $e) {
                }
            }
        }

        return false;
    }

    public function shouldConvertIDsToModels(): bool
    {
        return $this->evaluate($this->modelPrimaryKey) !== null;
    }

    public function getModelPrimaryKey(): string|null
    {
        return $this->evaluate($this->modelPrimaryKey);
    }
}
