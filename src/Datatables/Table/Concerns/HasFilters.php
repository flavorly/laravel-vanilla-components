<?php

namespace VanillaComponents\Datatables\Table\Concerns;

use Illuminate\Support\Collection;
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

    protected function getFilters(): Collection
    {
        if (empty($this->filters())) {
            return collect();
        }

        return collect($this->filters())
            ->mapWithKeys(function ($filter) {
                if (is_string($filter)) {
                    $filter = app($filter);

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
        return collect($this->filters())->map(fn ($filter) => $filter->getName());
    }

    protected function filtersToArray(): array
    {
        if (! empty($this->filters)) {
            return collect($this->filters)
                ->map(function ($filter) {
                    if ($filter instanceof Filter) {
                        return $filter->toArray();
                    }

                    if (is_a($filter, BaseComponent::class)) {
                        return $filter->toArray();
                    }

                    if (is_array($filter)) {
                        return $filter;
                    }

                    return [];
                })
                ->filter(fn ($filter) => ! empty($filter))
                ->toArray();
        }

        return [];
    }
}
