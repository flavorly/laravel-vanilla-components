<?php

namespace VanillaComponents\Datatables\Table\Concerns;

use VanillaComponents\Datatables\Columns\Column;

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
