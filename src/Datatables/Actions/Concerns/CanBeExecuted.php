<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Flavorly\VanillaComponents\Datatables\PendingAction\PendingAction;
use Flavorly\VanillaComponents\Events\DatatableActionExecuted;
use Flavorly\VanillaComponents\Events\DatatableActionFailed;
use Flavorly\VanillaComponents\Events\DatatableActionFinished;
use Flavorly\VanillaComponents\Events\DatatableActionStarted;
use Illuminate\Support\Collection;

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

    public function execute(Collection $requestData): void
    {
        $pendingAction = PendingAction::make()
            ->rows($requestData->get('rows'))
            ->allSelectedWhen($requestData->get('rows') === 'all')
            ->action($this);

        // Hook: Before
        if (class_implements($this, HasHooks::class) && $this->onBefore !== null) {
            app()->call($this->onBefore, ['pendingAction' => $pendingAction]);
        }

        event(new DatatableActionStarted($pendingAction));

        try {
            // Do nothing
            if ($this->executeUsing === null) {
            } elseif (method_exists($this, 'handle')) {
                app()->call([$this, 'handle'], ['pendingAction' => $pendingAction]);
            }
            // Action should be executed as a closure
            elseif ($this->getExecuteUsing() instanceof Closure) {
                app()->call($this->getExecuteUsing(), ['pendingAction' => $pendingAction]);
            }
            // Action is a class, lets invoke
            elseif (is_string($this->getExecuteUsing())) {
                // Method __invoke or chosen method does not exists on the class
                if (! method_exists($this->getExecuteUsing(), $this->executeUsingMethod)) {
                    throw new \Exception(sprintf('Method %s does not exist on Action [%s]', $this->executeUsingMethod, $this::class));
                }

                // Call the action using the choosen method, defaults to __invoke
                app()->call($this->getExecuteUsing(), ['pendingAction' => $pendingAction], $this->executeUsingMethod);
            }

            // Hook: After
            if (class_implements($this, HasHooks::class) && $this->onAfter !== null) {
                app()->call($this->onAfter, ['pendingAction' => $pendingAction]);
            }

            event(new DatatableActionExecuted($pendingAction));
        } catch (\Exception $e) {
            // Hook: Exception
            if (class_implements($this, HasHooks::class) && $this->onFailed !== null) {
                app()->call($this->onFailed, ['pendingAction' => $pendingAction]);
            }

            event(new DatatableActionFailed($pendingAction, $e));

            throw $e;
        } finally {
            // Hook: Finally / Finished
            if (class_implements($this, HasHooks::class) && $this->onFinished !== null) {
                app()->call($this->onFinished, ['pendingAction' => $pendingAction]);
            }

            event(new DatatableActionFinished($pendingAction));
        }
    }
}
