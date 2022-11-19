<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

use Flavorly\VanillaComponents\Datatables\Columns\Column;
use Illuminate\Support\Collection;

trait CanBeSorted
{
    /**
     * Collection of filters applied
     *
     * @var Collection<Column>
     */
    protected Collection $sorting;

    public function withSorting(Collection $sorting): static
    {
        if ($sorting->isEmpty()) {
            return $this;
        }

        // Filter the sorting
        $this->sorting = $sorting
            ->filter(function ($sorting) {
                // Empty
                if (empty($sorting)) {
                    return false;
                }

                // Not asc or desc
                if (! in_array($sorting['direction'], ['asc', 'desc'])) {
                    return false;
                }

                // Column doest not actual exists
                $column = $this->getTable()->getColumnByKey($sorting['column']);
                if (! $column) {
                    return false;
                }

                return $column->isSortable();
            })
            ->map(function ($sorting) {
                $column = $this->getTable()->getColumnByKey($sorting['column']);

                return $column->sortedAs($sorting['direction']);
            });

        return $this;
    }

    public function getSorting(): Collection
    {
        return $this->sorting;
    }

    public function hasSorting(): bool
    {
        return ! $this->sorting->isEmpty();
    }
}
