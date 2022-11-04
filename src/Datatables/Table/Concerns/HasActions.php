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
        return collect($this->actions)->map->toArray()->toArray();
    }
}
