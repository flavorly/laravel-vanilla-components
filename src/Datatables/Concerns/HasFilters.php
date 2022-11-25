<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use Flavorly\VanillaComponents\Core\Components\BaseComponent;
use Flavorly\VanillaComponents\Datatables\Filters\Filter;
use Illuminate\Support\Collection;

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

    public function getFilters(): Collection
    {
        if (empty($this->filters)) {
            return collect();
        }

        return collect($this->filters)
            ->mapWithKeys(function ($filter) {

                if (is_string($filter)) {
                    $filter = app($filter);
                    return [$filter->getName() => $filter];
                }

                if(is_a($filter, BaseComponent::class)){
                    $filter = Filter::fromComponent($filter);
                    return [$filter->getName() => $filter];
                }

                if (! $filter instanceof Filter) {
                    return [];
                }

                return [$filter->getName() => $filter];
            })
            ->filter(fn ($filter) => ! empty($filter));
    }

    protected function getFiltersKeys(): Collection
    {
        return collect($this->filters)->map(fn ($filter) => $filter->getName());
    }

    public function getFilterByKey(string $filterKey): ?Filter
    {
        return $this->getFilters()->first(fn ($item, $key) => $key === $filterKey);
    }

    protected function filtersToArray(): array
    {
        return $this->getFilters()->map(fn ($filter) => $filter->toArray())->values()->toArray();
    }
}
