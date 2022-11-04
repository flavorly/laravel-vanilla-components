<?php

namespace VanillaComponents\Datatables\Table\Concerns;

use VanillaComponents\Datatables\Actions\Action;

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

    protected function actionsToArray(): array
    {
        return collect($this->actions)->map(function ($action) {

            if(is_string($action)) {
                return app()->make($action)->toArray();
            }

            if($action instanceof Action) {
                return $action->toArray();
            }

            if(is_array($action)){
                return $action;
            }

            throw new \Exception('Invalid action type');
        })->toArray();
    }
}
