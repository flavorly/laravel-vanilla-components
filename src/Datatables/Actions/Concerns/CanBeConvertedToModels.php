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
        // If the user provided a callback
        if($this->executeUsing !== null){
            try {
                $reflection = new \ReflectionFunction($this->executeUsing);
                foreach($reflection->getParameters() as $parameter){
                    if(
                        $parameter->getType() === 'Illuminate\Database\Eloquent\Collection' ||
                        $parameter->getName() === 'models'
                    ){
                        return true;
                    }
                }
            } catch (\ReflectionException $e) {
            }
            return false;
        }


        // If the user provider a method instead
        $methodsToCheck = [
            'handle',
            '__invoke',
            $this->executeUsingMethod,
        ];

        foreach($methodsToCheck as $method){
            if(method_exists($this,$method)){
                try {
                    $reflection = new \ReflectionMethod($this,$method);
                    foreach($reflection->getParameters() as $parameter){
                        if(
                            $parameter->getType() === 'Illuminate\Database\Eloquent\Collection' ||
                            $parameter->getName() === 'models'
                        ){
                            return true;
                        }
                    }
                } catch (\ReflectionException $e) {
                }
            }
        }

        return false;
    }

    protected function shouldConvertIDsToModels(): bool
    {
        return $this->evaluate($this->modelPrimaryKey) !== null;
    }

    protected function getModelPrimaryKey(): string|null
    {
        return $this->evaluate($this->modelPrimaryKey);
    }
}
