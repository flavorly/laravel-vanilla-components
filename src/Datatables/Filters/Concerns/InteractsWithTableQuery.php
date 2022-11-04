<?php

namespace VanillaComponents\Datatables\Filters\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Builder;

trait InteractsWithTableQuery
{
    protected ?Closure $applyFilterUsing = null;

    public function apply(Builder $query, string $column, mixed $value): Builder
    {
        if($value === null) {
            return $query;
        }

        if($this->applyFilterUsing instanceof Closure) {
            $this->evaluate($this->applyFilterUsing, [
                'query' => $query,
                'column' => $column,
                'value' => $value,
            ]);
        }
        return $query->where($column, $value);
    }

    public function applyUsing(?Closure $callback): static
    {
        $this->applyFilterUsing = $callback;
        return $this;
    }
}
