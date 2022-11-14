<?php

namespace VanillaComponents\Datatables\Concerns;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Builder as ScoutBuilder;
use VanillaComponents\Datatables\Columns\Column;
use VanillaComponents\Datatables\Filters\Filter;
use VanillaComponents\Datatables\Http\Resources\DatatableResource;

trait InteractsWithQueryBuilder
{
    protected Builder|ScoutBuilder|null $query = null;

    protected function resolveQueryOrModel(Builder|Model|string|Closure $queryOrModel): Builder
    {
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

    protected function dispatchAction(): void
    {
    }

    public function response(Builder $queryOrModel = null): DatatableResource
    {
        // Attempt to always get a query builder
        $baseQuery = $this->resolveQueryOrModel($queryOrModel);

        // Get the columns defined
        $columns = $this->getColumns();

        // Get the filters
        $filters = $this->getFilters();

        // Get the possible options for per Page Options
        $perPageOptions = $this->getPerPageOptions();

        // The default option per page
        $defaultPerPageOption = $perPageOptions->first(fn ($item, $key) => $key === request()->input('perPage'))->getValue() ?? $perPageOptions->first()->getValue();


        $paginator = User::search(
            request()->get('search') ?? '',

            // We use scout for searching, the second argument we can modify the underlying query, so that we will be able to
            // Control the actual results, the base query constraints are merged into this.

            function (Builder $query) use ($columns, $filters, $baseQuery) {
                $query
                    // Select columns
                    ->select(array_keys($columns->toArray()))

                    // Merge previous query
                    ->mergeConstraintsFrom($baseQuery)

                    // Perform sorting
                    ->when(! empty(request()->input('sorting')), function (Builder|ScoutBuilder $subQuery) use ($columns) {

                        // Each column that needs to be sorted
                        collect(request()->input('sorting'))

                            // Filter the ones not present in the columns
                            ->filter(function ($sorting) use ($columns) {
                                if (empty($sorting)) {
                                    return false;
                                }
                                /** @var Column $column */
                                $column = $columns?->first(fn ($item, $key) => $key === $sorting['column']);
                                if (empty($column)) {
                                    return false;
                                }

                                return $column->isSortable();
                            })

                            // Apply Sorting
                            ->each(fn ($sorting) => $subQuery->orderBy($sorting['column'], $sorting['direction']));

                        return $subQuery;
                    })

                    // Filters
                    ->when(! empty(request()->input('filters')), function (Builder|ScoutBuilder $subQuery) use ($filters) {

                        // Each column that needs to be sorted
                        collect(request()->input('filters'))

                            // Filter the ones not present in the columns
                            ->filter(fn ($filterValue, $filterKey) => $filterValue !== null && $filters?->first(fn ($item, $key) => $key === $filterKey))

                            // Apply Sorting
                            ->each(function ($filterValue, $filterKey) use ($subQuery, $filters) {
                                $filter = $filters?->first(fn ($item, $key) => $key === $filterKey);
                                if ($filter instanceof Filter) {
                                    $filter->apply($subQuery, $filterKey, $filterValue);
                                }
                            });

                        return $subQuery;
                    });

                // Save the current query, and clone it.
                $this->query = $query->clone();
                return $query;
            }
        )
        ->paginate($defaultPerPageOption);



        return (new DatatableResource($paginator))->rightSideMaximumPages(3);
    }
}
