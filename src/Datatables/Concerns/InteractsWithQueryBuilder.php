<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use Closure;
use Exception;
use Flavorly\VanillaComponents\Datatables\Columns\Column;
use Flavorly\VanillaComponents\Datatables\Filters\Filter;
use Flavorly\VanillaComponents\Datatables\Http\Payload\RequestPayload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Collection;
use Laravel\Scout\Builder as ScoutBuilder;
use Laravel\Scout\Searchable;

trait InteractsWithQueryBuilder
{
    /**
     * Stores the query object
     */
    protected Builder|ScoutBuilder|null|Closure $query = null;

    /**
     * Stores the data comming from the client side
     */
    protected RequestPayload $data;

    /**
     * The actual query builder instance provided by the user.
     */
    public function query(): mixed
    {
        return $this->query;
    }

    /**
     * Return the query model/instance
     *
     * @return Closure|Builder|ScoutBuilder|null
     */
    protected function getQuery()
    {
        return $this->query;
    }

    /**
     * Boot the query and save it on the instance.
     */
    public function setupQuery(): void
    {
        $this->query = $this->resolveQueryOrModel($this->query());
    }

    /**
     * Injects the query into instance
     *
     * @param  Builder|ScoutBuilder  $query
     * @return $this
     */
    public function withQuery(mixed $query): static
    {
        if (null === $query) {
            return $this;
        }
        $this->query = $this->resolveQueryOrModel($query);

        $this->setupPrimaryKey();

        return $this;
    }

    /**
     * Attempts to resolve the query from a string, class or a model
     */
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

    /**
     * Apply the user provided filters using the follow method
     */
    protected function applyQueryFilters(Builder $query, RequestPayload $payload): Builder
    {
        return $query->when($payload->hasFilters(), function (Builder $subQuery) use ($payload) {
            // Each column that needs to be sorted
            $payload
                ->getFilters()
                // Apply Sorting
                ->each(fn (Filter $filter) => $filter->apply($subQuery, $filter->getName(), $filter->getValue()));

            return $subQuery;
        });
    }

    /**
     * Apply the sorting using the following method
     */
    protected function applyQuerySorting(Builder $query, RequestPayload $payload): Builder
    {
        return $query->when($payload->hasSorting(), function (Builder $subQuery) use ($payload) {
            // Each column that needs to be sorted
            $payload
                ->getSorting()
                ->each(fn (Column $column) => $subQuery->orderBy($column->getName(), $column->getSortDirection()));

            return $subQuery;
        });
    }

    /**
     * Apply the search using the following method, supporting scout if the class uses scout.
     */
    protected function applySearch(Builder $query, RequestPayload $payload): Builder
    {
        $model = $this->getQuery()->getModel();
        $usingScout = in_array(Searchable::class, class_uses($model::class));

        return $query
            // Model is using Scout, we can use it.
            ->when($usingScout && $payload->hasSearch(), function (Builder $subQuery) use ($model) {
                // Each column that needs to be sorted
                /** @var Searchable $model */
                $subQuery->whereIn('id', $model::search($this->data->getSearch())->keys());

                return $subQuery;
            })
            // Without Scout
            ->when(! $usingScout && $payload->hasSearch(), function (Builder $subQuery) use ($payload) {
                // Each column that needs to be sorted
                $subQuery
                    ->where(fn ($query) => $this
                        ->getColumns()
                        ->each(fn (Column $column) => $query->orWhere($column->getName(), 'like', "%{$payload->getSearch()}%"))
                    );

                return $subQuery;
            });
    }

    /**
     * Transform the Laravel pagination with Vanilla Datatable Pagination structure
     * The ideia was origonally taken from Reink at PingCRM Demo
     */
    protected function transformPagination(LengthAwarePaginator $paginator): array
    {
        $paginator->onEachSide = 1;
        $window = UrlWindow::make($paginator);

        $isLongPagination = is_array($window['slider']);
        $windowTruncated = $window;

        $rightSideMaximumPages = $isLongPagination ? 1 : 2;
        $leftSideMaximumPages = $isLongPagination ? 1 : 2;
        $middleMaximumPages = $isLongPagination ? 3 : 2;

        // First limit the items
        // Here we can properly control how much pages on each side
        if ($isLongPagination) {
            $windowTruncated = collect($window)
                ->map(function ($item, $key) use ($leftSideMaximumPages, $rightSideMaximumPages, $middleMaximumPages) {
                    if ($key == 'first') {
                        return collect($item)->slice(0, $leftSideMaximumPages)->toArray();
                    }

                    if ($key === 'last') {
                        return collect($item)->slice(0, $rightSideMaximumPages)->toArray();
                    }

                    if ($key === 'slider' && is_array($item)) {
                        return collect($item)->slice(0, $middleMaximumPages)->toArray();
                    }

                    return $item;
                })
                ->toArray();
        }

        // Keep the sliders
        $elements = array_filter([
            $windowTruncated['first'],
            is_array($windowTruncated['slider']) ? '...' : null,
            $windowTruncated['slider'],
            is_array($windowTruncated['last']) ? '...' : null,
            $windowTruncated['last'],
        ]);

        // Clear the pages
        $pages = Collection::make($elements)->flatMap(function ($item) use ($paginator) {
            if (is_array($item)) {
                return Collection::make($item)->map(fn ($url, $page) => [
                    'url' => $url,
                    'label' => $page,
                    'active' => $paginator->currentPage() === $page,
                ]);
            } else {
                return [
                    [
                        'url' => null,
                        'label' => '...',
                        'active' => false,
                    ],
                ];
            }
        });

        // Finnaly return the data
        return [
            'data' => $paginator->items(),
            'links' => [
                'pages' => $pages,
                'next' => $paginator->nextPageUrl(),
                'previous' => $paginator->previousPageUrl(),
            ],
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'from' => $paginator->firstItem(),
                'last_page' => $paginator->lastPage(),
                'path' => $paginator->path(),
                'per_page' => $paginator->perPage(),
                'to' => $paginator->lastItem(),
                'total' => $paginator->total(),
            ],
        ];
    }

    /**
     * Process an action once is dispatched from the frontend to the backend
     *
     *
     * @throws Exception
     */
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

    /**
     * If no query is provided, we will use the default query from the model
     * otherwise we can inject the user provided query into the table.
     *
     *
     *
     * @throws Exception
     */
    public function response(?Builder $queryOrModel = null): array|Collection
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

        $query = $this->getQuery();

        $this->query = tap($query, function () use (&$query) {
            $this->applyQueryFilters($query, $this->data);
            $this->applyQuerySorting($query, $this->data);
            $this->applySearch($query, $this->data);
        });

        /** @var LengthAwarePaginator $collection */
        $collection = $query->paginate($this->data->getPerPage());

        if (method_exists($this, 'transform')) {
            $collection->transform(fn ($record) => $this->transform($record));
        }

        // Append the query, because at this point we are done with it.
        $this->data->withQuery($this->query);

        // Dispatch the action
        $this->dispatchAction();

        return $this->transformPagination($collection);
    }
}
