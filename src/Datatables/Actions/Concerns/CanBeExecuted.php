<?php

namespace VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Auth\Events\Verified;
use VanillaComponents\Events\DatatableActionExecuted;
use VanillaComponents\Events\DatatableActionFailed;
use VanillaComponents\Events\DatatableActionFinished;
use VanillaComponents\Events\DatatableActionStarted;

trait CanBeExecuted
{
    protected null | Closure | string $executeUsing = null;

    protected ?string $executeUsingMethod = null;

    public function executeUsing(Closure|null|string $closureOrInvokable = null, ?string $method = '__invoke'): static
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
        // Hook: Before
        if (class_implements($this, HasHooks::class) && $this->onBefore !== null) {
            app()->call($this->onBefore, [
                'action' => $this,
                'ids' => $ids,
            ]);
        }

        event(new DatatableActionStarted($this, $ids));

        try {
            // Do nothing
            if ($this->executeUsing === null) {
            } elseif (method_exists($this, 'handle')) {
                app()->call([$this, 'handle'], ['action' => $this, 'ids' => $ids]);
            }
            // Action should be executed as a closure
            elseif ($this->getExecuteUsing() instanceof Closure) {
                app()->call($this->getExecuteUsing(), ['action' => $this, 'ids' => $ids]);
            }
            // Action is a class, lets invoke
            elseif (is_string($this->getExecuteUsing())) {
                // Method __invoke or chosen method does not exists on the class
                if (! method_exists($this->getExecuteUsing(), $this->executeUsingMethod)) {
                    throw new \Exception(sprintf('Method %s does not exist on Action [%s]', $this->executeUsingMethod, $this::class));
                }

                // Call the action using the choosen method, defaults to __invoke
                app()->call($this->getExecuteUsing(), ['action' => $this, 'ids' => $ids], $this->executeUsingMethod);
            }

            // Hook: After
            if (class_implements($this, HasHooks::class) && $this->onAfter !== null) {
                app()->call($this->onAfter, ['action' => $this, 'ids' => $ids]);
            }

            event(new DatatableActionExecuted($this, $ids));

        } catch (\Exception $e) {
            // Hook: Exception
            if (class_implements($this, HasHooks::class) && $this->onFailed !== null) {
                app()->call($this->onFailed, [
                    'action' => $this,
                    'ids' => $ids,
                    'exception' => $e,
                ]);
            }

            event(new DatatableActionFailed($this, $ids, $e));

            throw $e;
        } finally {
            // Hook: Finally / Finished
            if (class_implements($this, HasHooks::class) && $this->onFinished !== null) {
                app()->call($this->onFinished, [
                    'action' => $this,
                    'ids' => $ids,
                ]);
            }

            event(new DatatableActionFinished($this, $ids));
        }
    }
}
