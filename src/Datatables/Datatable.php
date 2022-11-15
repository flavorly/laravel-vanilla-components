<?php

namespace Flavorly\VanillaComponents\Datatables;

use Illuminate\Support\Traits\Macroable;
use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;

abstract class Datatable
{
    use CoreConcerns\Makable;
    use CoreConcerns\EvaluatesClosures;
    use Concerns\HasActions;
    use Concerns\HasOptions;
    use Concerns\HasColumns;
    use Concerns\HasFilters;
    use Concerns\HasTranslations;
    use Concerns\HasPolling;
    use Concerns\HasPageOptions;
    use Concerns\HasName;
    use Concerns\HasEndpoint;
    use Concerns\InteractsWithQueryBuilder;
    use Macroable;

    public function __construct()
    {
        $this->setup();
    }

    protected function setup(): void
    {
        $this->setupName();
        $this->setupEndpoints();
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
        return [
            'fetchEndpoint' => $this->getFetchEndpoint(),
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
