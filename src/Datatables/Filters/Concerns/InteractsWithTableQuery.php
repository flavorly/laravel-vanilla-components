<?php

namespace Flavorly\VanillaComponents\Datatables\Filters\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait InteractsWithTableQuery
{
    protected ?Closure $applyFilterUsing = null;

    public function apply(Builder $query, string $column, mixed $value): Builder
    {
        if ($value === null) {
            return $query;
        }

        if ($this->applyFilterUsing instanceof Closure) {
            return $this->evaluate($this->applyFilterUsing, [
                'query' => $query,
                'column' => $column,
                'value' => $value,
            ]);
        }

        if (Str::of($column)->contains('.')) {
            [$relation, $relationshipColumn] = Str::of($column)->explode('.');
            if (filled($relation) && filled($relationshipColumn)) {
                return $query->whereHas($relation, fn (Builder $query) => $query->where($relationshipColumn, $value));
            }
        }

        return $query->where($column, $value);
    }

    public function applyUsing(?Closure $callback): static
    {
        $this->applyFilterUsing = $callback;

        return $this;
    }
}
