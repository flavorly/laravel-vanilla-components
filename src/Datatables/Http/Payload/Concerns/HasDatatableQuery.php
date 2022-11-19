<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Builder as ScoutBuilder;

trait HasDatatableQuery
{
    protected Builder|ScoutBuilder|null $query;

    public function withQuery(Builder|ScoutBuilder|null $query = null): static
    {
        $this->query = $query;

        return $this;
    }

    public function hasQuery(): bool
    {
        return ! is_null($this->query);
    }

    public function getQuery(): Builder|ScoutBuilder|null
    {
        return $this->query;
    }
}
