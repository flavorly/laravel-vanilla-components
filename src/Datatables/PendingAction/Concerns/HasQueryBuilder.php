<?php

namespace VanillaComponents\Datatables\PendingAction\Concerns;

use Laravel\Scout\Builder as ScoutBuilder;
use Illuminate\Database\Eloquent\Builder;

trait HasQueryBuilder
{
    protected Builder|ScoutBuilder|null $queryBuilder = null;

    public function withQuery(Builder|ScoutBuilder|null $queryBuilder = null): static
    {
        $this->queryBuilder = $queryBuilder;
        return $this;
    }

    public function getQuery(): Builder|ScoutBuilder|null
    {
        return $this->queryBuilder;
    }
}
