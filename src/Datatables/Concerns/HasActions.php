<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use Flavorly\VanillaComponents\Datatables\Actions\Action;
use Illuminate\Support\Collection;

trait HasActions
{
    /** @var Action[] */
    protected array $actions = [];

    public function actions(): array
    {
        return [];
    }

    protected function setupActions(): void
    {
        $this->actions = $this->actions();
    }

    protected function getActions(): Collection
    {
        if (empty($this->actions())) {
            return collect();
        }

        return collect($this->actions())
            ->mapWithKeys(function ($action) {
                if (is_string($action)) {
                    $action = app($action);

                    return [$action->getName() => $action];
                }

                if (! $action instanceof Action) {
                    return [];
                }

                return [$action->getName() => $action];
            })
            ->filter(fn ($action) => ! empty($action));
    }

    protected function getActionsKeys(): Collection
    {
        return collect($this->actions())->map(fn ($action) => $action->getName());
    }

    protected function getActionByKey(string $actionKey): ?Action
    {
        return $this->getActions()->first(fn ($item, $key) => $key === $actionKey);
    }

    protected function actionsToArray(): array
    {
        return collect($this->actions)->map(function ($action) {
            if (is_string($action)) {
                return app()->make($action)->toArray();
            }

            if ($action instanceof Action) {
                return $action->toArray();
            }

            if (is_array($action)) {
                return $action;
            }

            throw new \Exception('Invalid action type');
        })->toArray();
    }
}
