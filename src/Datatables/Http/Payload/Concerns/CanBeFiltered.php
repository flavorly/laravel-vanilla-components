<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

use Flavorly\VanillaComponents\Datatables\Filters\Filter;
use Illuminate\Support\Collection;

trait CanBeFiltered
{
    /**
     * Collection of filters applied
     *
     * @var Collection<Filter>
     */
    protected Collection $filters;

    public function withFilters(Collection $filters): static
    {
        if ($filters->isEmpty()) {
            return $this;
        }

        // Filter the sorting
        $this->filters = $filters
            ->filter(function ($filterValue, $filterKey) {
                return $filterValue !== null && $this->getTable()->getFilterByKey($filterKey) !== null;
            })
            ->mapWithKeys(function ($filterValue, $filterKey) {
                $filter = $this->getTable()->getFilterByKey($filterKey);
                $filter->value($filterValue);

                return [$filterKey => $filter];
            });

        return $this;
    }

    public function getFilters(): Collection
    {
        return $this->filters;
    }

    public function hasFilters(): bool
    {
        return ! $this->filters->isEmpty();
    }
}
