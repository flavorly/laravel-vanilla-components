<?php

namespace VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Illuminate\Support\Collection;

trait CanBeExecuted
{
    protected null | Closure | string $executeUsing = null;
    protected ?string $executeUsingMethod = null;

    public function executeUsing(Closure|null|string $closureOrInvokable = null, ?string $method = null): static
    {
        $this->executeUsing = $closureOrInvokable;
        $this->executeUsingMethod = $method;
        return $this;
    }

    protected function getExecuteUsing(): null | Closure | string
    {
        return $this->executeUsing;
    }

    public function execute(?Collection $ids = null): void
    {

        // Execute the before Hook
        if(class_implements($this,HasHooks::class) && $this->onBefore !== null){
            app()->call($this->onBefore, [
                'action' => $this,
                'ids' => $ids,
            ], $this->executeUsingMethod);
        }

        try{

            // Do nothing
            if($this->executeUsing === null){

            }
            elseif(method_exists($this,'handle')){
                app()->call([$this,'handle'], [
                    'action' => $this,
                    'ids' => $ids,
                ], $this->executeUsingMethod);
            }
            // Action should be executed as a closure
            elseif($this->getExecuteUsing() instanceof Closure) {
                app()->call($this->getExecuteUsing(), [
                    'action' => $this,
                    'ids' => $ids,
                ], $this->executeUsingMethod);
            }

            // Action is a class, lets invoke
            elseif(is_string($this->getExecuteUsing())) {
                app()->call($this->getExecuteUsing(), [
                    'action' => $this,
                    'ids' => $ids,
                ],$this->executeUsingMethod);
            }

            // Execute the After Hook
            if(class_implements($this,HasHooks::class) && $this->onAfter !== null){
                app()->call($this->onAfter, [
                    'action' => $this,
                    'ids' => $ids,
                ], $this->executeUsingMethod);
            }

        }catch (\Exception $e){

            // Execute on Exception/Failed
            if(class_implements($this,HasHooks::class) && $this->onFailed !== null){
                app()->call($this->onFailed, [
                    'action' => $this,
                    'ids' => $ids,
                    'exception' => $e,
                ], $this->executeUsingMethod);
            }

        } finally {
            // Execute the before Hook
            if(class_implements($this,HasHooks::class) && $this->onFinished !== null){
                app()->call($this->onFinished, [
                    'action' => $this,
                    'ids' => $ids,
                ], $this->executeUsingMethod);
            }
        }
    }
}
