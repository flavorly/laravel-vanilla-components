<?php

namespace VanillaComponents\Datatables;

use VanillaComponents\Core\Concerns as CoreConcerns;
use VanillaComponents\Datatables\Table\Concerns;

abstract class Datatable
{
    use CoreConcerns\Makable;
    use Concerns\HasActions;
    use Concerns\HasOptions;
    use Concerns\HasColumns;
    use Concerns\HasFilters;
    use Concerns\HasTranslations;
    use Concerns\HasPolling;
    use Concerns\HasPageOptions;
    use Concerns\HasName;

    public function __construct()
    {
    }

    protected function setup(): void
    {
        $this->setupName();
        $this->setupActions();
        $this->setupOptions();
        $this->setupColumns();
        $this->setupPolling();
        $this->setupFilters();
        $this->setupPerPageOptions();
        $this->setupTranslations();
    }

    public function toArray(): array
    {
        $this->setup();

        return [
            'name' => $this->getName(),
            'actions' => $this->actionsToArray(),
            'columns' => $this->columnsToArray(),
            'filters' => $this->filtersToArray(),
            'pageOptions' => $this->perPageOptionsToArray(),
            'poolingOptions' => $this->pollingToArray(),
            'options' => $this->optionsToArray(),
            'translations' => $this->translationsToArray(),
        ];
    }
}
