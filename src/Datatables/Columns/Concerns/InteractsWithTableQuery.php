<?php

namespace Flavorly\VanillaComponents\Datatables\Columns\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait InteractsWithTableQuery
{
    protected ?Closure $applySortingUsing = null;

    public function applySort(Builder $query, string $column, mixed $sorting): Builder
    {
        if ($sorting === null) {
            return $query;
        }

        if ($this->applySortingUsing instanceof Closure) {
            return $this->evaluate($this->applySortingUsing, [
                'query' => $query,
                'column' => $column,
                'sorting' => $sorting,
            ]);
        }

        return $query->orderBy($column, $sorting);
    }

    public function sortUsing(?Closure $callback): static
    {
        $this->applySortingUsing = $callback;

        return $this;
    }
}
