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

        $method = 'where';
        if (is_array($value) || Str::of($value)->contains(',')) {
            $method = 'whereIn';
            if(is_string($value) && Str::of($value)->contains(',')){
                $value = array_values(array_filter(explode(',', $value)));
            }
        }

        if(is_array($value) && empty($value)){
            return $query;
        }

        // Relationships Query
        if (Str::of($column)->contains('.')) {
            [$relation, $relationshipColumn] = Str::of($column)->explode('.');
            if (filled($relation) && filled($relationshipColumn)) {
                return $query->whereHas($relation, function(Builder $query) use($value, $relationshipColumn, $method){
                        return $query->{$method}($relationshipColumn,$value);
                });
            }
        }

        // Own table query
        return $query->$method($column, $value);
    }

    public function applyUsing(?Closure $callback): static
    {
        $this->applyFilterUsing = $callback;

        return $this;
    }
}
