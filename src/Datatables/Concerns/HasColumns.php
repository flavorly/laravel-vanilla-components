<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use Flavorly\VanillaComponents\Datatables\Columns\Column;
use Illuminate\Support\Collection;

trait HasColumns
{
    /** @var Column[] */
    protected array $columns = [];

    public function columns(): array
    {
        return [];
    }

    protected function setupColumns(): void
    {
        $this->columns = $this->columns();
    }

    protected function getColumns(): Collection
    {
        if (empty($this->columns())) {
            return collect();
        }

        return collect($this->columns())
            ->mapWithKeys(function ($column) {
                if (is_string($column)) {
                    $column = app($column);

                    return [$column->getName() => $column];
                }

                if (! $column instanceof Column) {
                    return [];
                }

                return [$column->getName() => $column];
            })
            ->filter(fn ($column) => ! empty($column));
    }

    protected function getColumnKeys(): Collection
    {
        return collect($this->columns())->map(fn ($column) => $column->getName());
    }

    protected function getColumnByKey(string $columnKey): ?Column
    {
        return $this->getColumns()->first(fn ($item, $key) => $key === $columnKey);
    }

    protected function columnsToArray(): array
    {
        if (! empty($this->columns)) {
            return collect($this->columns)
            ->map(function ($column) {
                if ($column instanceof Column) {
                    return $column->toArray();
                }
                if (is_array($column)) {
                    return $column;
                }

                return [];
            })
            ->filter(fn ($column) => ! empty($column))
            ->toArray();
        }

        return [];
    }
}
