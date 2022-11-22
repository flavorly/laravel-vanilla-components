<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Builder as ScoutBuilder;

trait InteractsWithQueryBuilder
{
    protected Builder|ScoutBuilder|null $query = null;

    public function query(): Builder|ScoutBuilder|null
    {
        return $this->query;
    }

    public function setupQuery(): void
    {
        $this->query = $this->query();
    }

    protected function resolveQueryOrModel(Builder|Model|string|Closure|null $queryOrModel = null): Builder
    {
        // Query already present or set
        if(null !== $this->query && $queryOrModel === null) {
            return $this->query;
        }

        // If the user has not provided a query or passed a string ( class ) we will try to
        // get the query from the model
        if (is_string($queryOrModel)) {
            $queryOrModel = app($queryOrModel);
        }

        if ($queryOrModel instanceof Closure) {
            $queryOrModel = $this->evaluate($queryOrModel);
        }

        // Attempt to always get a query builder
        return $queryOrModel instanceof Builder ? $queryOrModel : $queryOrModel->query();
    }
}
