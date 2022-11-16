<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Flavorly\VanillaComponents\Datatables\Data\DatatableRequest;
use Flavorly\VanillaComponents\Events\DatatableActionExecuted;
use Flavorly\VanillaComponents\Events\DatatableActionFailed;
use Flavorly\VanillaComponents\Events\DatatableActionFinished;
use Flavorly\VanillaComponents\Events\DatatableActionStarted;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Builder as ScoutBuilder;

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

    public function execute(DatatableRequest $data, ScoutBuilder|Builder $queryBuilder): void
    {
        $payload = ['action' => $this, 'data' => $data, 'query' => $queryBuilder];

        // Hook: Before
        if (class_implements($this, HasHooks::class) && $this->onBefore !== null) {
            app()->call($this->onBefore, $payload);
        }

        event(new DatatableActionStarted($data, $this));

        try {
            // No method registered or callback
            if ($this->executeUsing === null) {
                throw new \Exception('Please make sure you call the executeUsing with either closure or a class to perform the action');
            }

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

            event(new DatatableActionExecuted($data, $this));
        } catch (\Exception $e) {
            // Hook: Exception
            if (class_implements($this, HasHooks::class) && $this->onFailed !== null) {
                app()->call($this->onFailed, $payload);
            }

            event(new DatatableActionFailed($data, $e));

            throw $e;
        } finally {
            // Hook: Finally / Finished
            if (class_implements($this, HasHooks::class) && $this->onFinished !== null) {
                app()->call($this->onFinished, $payload);
            }

            event(new DatatableActionFinished($data, $this));
        }
    }
}
