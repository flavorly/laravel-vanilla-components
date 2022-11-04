<?php

namespace VanillaComponents\Datatables\Table\Concerns;

//use VanillaComponents\Datatables\Actions\Filters;

use VanillaComponents\Core\Components\BaseComponent;
use VanillaComponents\Datatables\Filters\Filter;

trait HasFilters
{
    /** @var Filter[] */
    protected array $filters = [];

    public function filters(): array
    {
        return [];
    }

    protected function setupFilters(): void
    {
        $this->filters = $this->filters();
    }

    protected function filtersToArray(): array
    {
        if(!empty($this->filters)) {
            return collect($this->filters)
                ->map(function($filter){

                    if($filter instanceof Filter) {
                        return $filter->toArray();
                    }

                    if(is_a($filter,BaseComponent::class)) {
                        return $filter->toArray();
                    }

                    if(is_array($filter)){
                        return $filter;
                    }
                    return [];
                })
                ->filter(fn($filter) => !empty($filter))
                ->toArray();
        }
        return [];
    }
}
