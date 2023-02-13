<?php

namespace Flavorly\VanillaComponents\Datatables;

use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Illuminate\Support\Traits\Macroable;

abstract class Datatable
{
    use CoreConcerns\Makable;
    use CoreConcerns\EvaluatesClosures;
    use Concerns\InteractsWithQueryBuilder;
    use Concerns\HasName;
    use Concerns\HasActions;
    use Concerns\HasOptions;
    use Concerns\HasColumns;
    use Concerns\HasFilters;
    use Concerns\HasFiltersFromURI;
    use Concerns\HasTranslations;
    use Concerns\HasPolling;
    use Concerns\HasPrimaryKey;
    use Concerns\HasPageOptions;
    use Concerns\HasEndpoint;
    use Concerns\HasOriginUrl;
    use Macroable;

    public function __construct()
    {
        $this->setup();
    }

    protected function setup(): void
    {
        $this->setupQuery();
        $this->setupName();
        $this->setupPrimaryKey();
        $this->setupEndpoints();
        $this->setupActions();
        $this->setupOptions();
        $this->setupColumns();
        $this->setupPolling();
        $this->setupFilters();
        $this->setupFiltersFromURL();
        $this->setupPerPageOptions();
        $this->setupTranslations();
        $this->setupOriginUrl();
    }

    public function toArray(): array
    {
        return [
            'primaryKey' => $this->getPrimaryKey(),
            'fetchEndpoint' => $this->getFetchEndpoint(),
            'name' => $this->getName(),
            'actions' => $this->actionsToArray(),
            'columns' => $this->columnsToArray(),
            'filters' => $this->filtersToArray(),
            'perPageOptions' => $this->perPageOptionsToArray(),
            'poolingOptions' => $this->pollingToArray(),
            'options' => $this->optionsToArray(),
            'translations' => $this->translationsToArray(),
        ];
    }
}
