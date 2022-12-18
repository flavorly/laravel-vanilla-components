<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Laravel\Scout\Builder as ScoutBuilder;

trait InteractsWithQueryBuilder
{
    protected Builder|ScoutBuilder|null|Closure $query = null;

    public function query(): mixed
    {
        return $this->query;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setupQuery(): void
    {
        $this->query = $this->resolveQueryOrModel($this->query());
    }

    public function withQuery(mixed $query)
    {
        if (null === $query) {
            return $this;
        }
        $this->query = $this->resolveQueryOrModel($query);

        $this->setupPrimaryKey();

        return $this;
    }

    protected function resolveQueryOrModel(mixed $queryOrModel = null): Builder
    {
        // If the user has not provided a query or passed a string ( class ) we will try to
        // get the query from the model
        if (is_string($queryOrModel)) {
            $queryOrModel = app($queryOrModel);
        }

        if ($queryOrModel instanceof Closure) {
            $queryOrModel = $this->evaluate($queryOrModel);
        }

        if ($queryOrModel instanceof Relation) {
            return $queryOrModel->getQuery();
        }

        // Attempt to always get a query builder
        return $queryOrModel instanceof Builder ? $queryOrModel : $queryOrModel->query();
    }
}
