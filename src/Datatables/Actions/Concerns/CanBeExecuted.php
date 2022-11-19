<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Flavorly\VanillaComponents\Datatables\Exceptions\DatatableActionMethodMissingException;
use Flavorly\VanillaComponents\Events\DatatableActionExecuted;
use Flavorly\VanillaComponents\Events\DatatableActionFailed;
use Flavorly\VanillaComponents\Events\DatatableActionFinished;
use Flavorly\VanillaComponents\Events\DatatableActionStarted;
use Illuminate\Support\Collection;

trait CanBeExecuted
{
    protected null | Closure | string $executeUsing = null;

    protected ?string $executeUsingMethod = null;

    public function using(Closure|null|string $closureOrInvokable = null, ?string $method = 'handle'): static
    {
        $this->executeUsing = $closureOrInvokable;
        $this->executeUsingMethod = $method;
        return $this;
    }

    protected function getExecuteUsing(): null | Closure | string
    {
        return $this->executeUsing;
    }

    protected function getDefaultMethodsToCheck(): Collection
    {
        return collect([
            'handle',
            '__invoke',
            $this->executeUsingMethod,
        ])->filter(fn($item) => !empty($item));
    }

    protected function isAnyOfTheMethodsImplemented(): bool
    {
        if($this->executeUsing !== null){
            return true;
        }

        return $this->getDefaultMethodsToCheck()->contains(function($method){
            return method_exists($this,$method);
        });
    }

    protected function getFirstMethodThatExists(): ?string
    {
        if($this->executeUsing !== null){
            return $this->executeUsingMethod;
        }

        return $this->getDefaultMethodsToCheck()->first(function($method){
            return method_exists($this,$method);
        });
    }

    public function execute(): void
    {
        // Resolve models
        $this->getData()->resolveModels();

        // Payload injected to all the stuff while executing a action
        $payload = [
            'data' => $this->getData(),
            'models' => $this->getData()->getModels(),
        ];

        // Hook: Before
        if (class_implements($this, HasHooks::class) && $this->onBefore !== null) {
            app()->call($this->onBefore,$payload);
        }

        event(new DatatableActionStarted($this->getData(), $this));

        try {

            // No method registered or callback
            throw_if(!$this->isAnyOfTheMethodsImplemented(),new DatatableActionMethodMissingException());

            // Closure executing
            if($this->executeUsing instanceof Closure){
                app()->call($this->executeUsing,$payload);
            }
            // Its a string or a class, we will attempt to call it.
            elseif(is_string($this->executeUsing)){
                app()->call([$this->executeUsing,$this->getFirstMethodThatExists()],$payload,$this->executeUsingMethod);
            }
            else {
                app()->call([$this,$this->getFirstMethodThatExists()],$payload);
            }

            // Hook: After
            if (class_implements($this, HasHooks::class) && $this->onAfter !== null) {
                app()->call($this->onAfter, $payload);
            }

            event(new DatatableActionExecuted($this->getData(),$this));
        } catch (\Exception $e) {
            // Hook: Exception
            if (class_implements($this, HasHooks::class) && $this->onFailed !== null) {
                app()->call($this->onFailed, $payload);
            }

            event(new DatatableActionFailed($this->getData(),$this, $e));

            throw $e;
        } finally {
            // Hook: Finally / Finished
            if (class_implements($this, HasHooks::class) && $this->onFinished !== null) {
                app()->call($this->onFinished, $payload);
            }

            event(new DatatableActionFinished($this->getData(),$this));
        }
    }
}
