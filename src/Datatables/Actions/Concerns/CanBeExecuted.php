<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Flavorly\VanillaComponents\Events\DatatableActionExecuted;
use Flavorly\VanillaComponents\Events\DatatableActionFailed;
use Flavorly\VanillaComponents\Events\DatatableActionFinished;
use Flavorly\VanillaComponents\Events\DatatableActionStarted;

trait CanBeExecuted
{
    protected null | Closure | string $executeUsing = null;

    protected ?string $executeUsingMethod = 'handle';

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

    public function execute(): void
    {
        // Payload injected to all the stuff while executing a action
        $payload = [
            'data' => $this->getData(),
        ];

        // Hook: Before
        if (class_implements($this, HasHooks::class) && $this->onBefore !== null) {
            app()->call($this->onBefore, $payload);
        }

        event(new DatatableActionStarted($this->getData(), $this));

        try {
            // No method registered or callback
            if ($this->executeUsing === null && ! method_exists($this, 'handle')) {
                throw new \Exception('Please make sure you call the using with either a closure or a class to perform the action');
            }

            // If user provided a instance instead with a handle method
            if (method_exists($this, 'handle')) {
                app()->call([$this, 'handle'], $payload);
            }

            // Action should be executed as a closure
            elseif ($this->getExecuteUsing() instanceof Closure) {
                app()->call($this->getExecuteUsing(), $payload);
            }
            // Action is a class, lets invoke
            elseif (is_string($this->getExecuteUsing())) {
                // Method __invoke or chosen method does not exists on the class
                if (! method_exists($this->getExecuteUsing(), $this->executeUsingMethod)) {
                    throw new \Exception(sprintf('Method %s does not exist on Action [%s]', $this->executeUsingMethod, $this::class));
                }

                // Call the action using the choosen method, defaults to __invoke
                app()->call(
                    $this->getExecuteUsing(),
                    $payload,
                    $this->executeUsingMethod
                );
            }

            // Hook: After
            if (class_implements($this, HasHooks::class) && $this->onAfter !== null) {
                app()->call($this->onAfter, $payload);
            }

            event(new DatatableActionExecuted($this->getData(), $this));
        } catch (\Exception $e) {
            // Hook: Exception
            if (class_implements($this, HasHooks::class) && $this->onFailed !== null) {
                app()->call($this->onFailed, $payload);
            }

            event(new DatatableActionFailed($this->getData(), $this, $e));

            throw $e;
        } finally {
            // Hook: Finally / Finished
            if (class_implements($this, HasHooks::class) && $this->onFinished !== null) {
                app()->call($this->onFinished, $payload);
            }

            event(new DatatableActionFinished($this->getData(), $this));
        }
    }
}
