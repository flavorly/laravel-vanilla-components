<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use Closure;
use Flavorly\VanillaComponents\Datatables\Columns\Column;
use Flavorly\VanillaComponents\Datatables\Filters\Filter;
use Flavorly\VanillaComponents\Datatables\Http\Payload\RequestPayload;
use Flavorly\VanillaComponents\Datatables\Http\Resources\DatatableResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Laravel\Scout\Builder as ScoutBuilder;
use Laravel\Scout\Searchable;

trait InteractsWithQueryBuilder
{
    protected Builder|ScoutBuilder|null|Closure $query = null;

    protected RequestPayload $data;

    public function query(): mixed
    {
        return $this->query;
    }

    protected function getQuery()
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

    protected function dispatchAction(): void
    {
        if (
            $this->data->hasAction() &&
            ($this->data->isAllSelected() || $this->data->hasSelectedRows())
        ) {
            // Execute the action
            $this->data->getAction()->execute();
        }
    }

    protected function applyQueryFilters(Builder $query, RequestPayload $payload): Builder
    {
        return $query->when($payload->hasFilters(), function (Builder $subQuery) use($payload){
            // Each column that needs to be sorted
            $payload
                ->getFilters()
                // Apply Sorting
                ->each(fn (Filter $filter) => $filter->apply($subQuery, $filter->getName(), $filter->getValue()));
            return $subQuery;
        });
    }

    protected function applyQuerySorting(Builder $query, RequestPayload $payload): Builder
    {
        return $query->when($payload->hasSorting(), function (Builder $subQuery) use($payload) {
            // Each column that needs to be sorted
            $payload
                ->getSorting()
                ->each(fn (Column $column) => $subQuery->orderBy($column->getName(), $column->getSortDirection()));

            return $subQuery;
        });
    }

    protected function applySearch(Builder $query, RequestPayload $payload): Builder
    {
        $model = $this->getQuery()->getModel();
        $usingScout = is_a($model, Searchable::class, true);

        return $query
            // Model is using Scout, we can use it.
            ->when($usingScout && $payload->hasSearch(), function (Builder $subQuery) use($payload, $model) {
                // Each column that needs to be sorted
                /** @var Searchable $model */
                $subQuery->whereIn('id', $model::search($this->data->getSearch())->keys());
                return $subQuery;
            })
            // Without Scout
            ->when(!$usingScout && $payload->hasSearch(), function (Builder $subQuery) use($payload) {
                // Each column that needs to be sorted
                $subQuery
                    ->where(fn($query) => $this
                        ->getColumns()
                        ->each(fn (Column $column) => $query->orWhere($column->getName(), 'like', "%{$payload->getSearch()}%"))
                    );
                return $subQuery;
            });
    }

    public function response(?Builder $queryOrModel = null): DatatableResource
    {
        // Create the data from the request payload
        // First we need to infer the table.
        $this->data = RequestPayload::make()
            ->table($this)
            ->fromRequest();

        // Attempt to always get a query builder
        if ($queryOrModel !== null) {
            $this->withQuery($queryOrModel);
        }

        $query = tap($this->getQuery(), function(Builder $query) {
            $query = $this->applyQueryFilters($query, $this->data);
            $query = $this->applyQuerySorting($query, $this->data);
            return $this->applySearch($query, $this->data);
        });

        $this->query = $query;

        $paginatedQuery = $query->paginate($this->data->getPerPage());

        // Append the query, because at this point we are done with it.
        $this->data->withQuery($this->query);

        // Dispatch the action
        $this->dispatchAction();

        $response = (new DatatableResource($paginatedQuery));

        // Ensure we can transform the data that is being displayed
        if (method_exists($this, 'transform')) {
            $response->transformResponseUsing(fn ($record) => $this->transform($record));
        }

        // Ensure we can transform the data that is being displayed
        $pagination = 3;
        if (property_exists($this, 'paginationItems')) {
            $pagination = $this->paginationItems;
        }

        return $response->rightSideMaximumPages($pagination);
    }
}
