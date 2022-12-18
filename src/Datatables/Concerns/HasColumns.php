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
        if (empty($this->columns)) {
            return collect();
        }

        return collect($this->columns)
            ->mapWithKeys(function ($column) {
                if (is_string($column)) {
                    $column = app($column);
                }

                if (! $column instanceof Column) {
                    return [];
                }

                $column->table($this);

                return [$column->getName() => $column];
            })
            ->filter(fn ($column) => ! empty($column));
    }

    protected function getColumnKeys(): Collection
    {
        return collect($this->columns)
            ->filter(fn (Column $column) => $column->selectable())
            ->map(function (Column $column) {
                return $column->getName();
            });
    }

    public function getColumnByKey(string $columnKey): ?Column
    {
        return $this->getColumns()->first(fn ($item, $key) => $key === $columnKey);
    }

    protected function columnsToArray(): array
    {
        return $this->getColumns()->map(fn ($column) => $column->toArray())->values()->toArray();
    }
}
