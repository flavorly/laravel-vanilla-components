<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use Flavorly\VanillaComponents\Datatables\Filters\Filter;

trait HasFiltersFromURI
{
    public function setupFiltersFromURL(): void
    {
        if(request()->has($this->getName())){

            $filtersFromRequest = collect(request()->get($this->getName(),[]));

            if ($filtersFromRequest->isEmpty()) {
                return;
            }

            // Filter the sorting
            $this->filters = $this
                ->getFilters()
                ->map(function (Filter $filter) use($filtersFromRequest) {
                    $filterValue = $filtersFromRequest->get($filter->getName());
                    $filter->value($filterValue);
                    return $filter;
                })
                ->toArray();
        }
    }
}
