<?php

namespace VanillaComponents\Datatables\Table\Concerns;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Builder as ScoutBuilder;
use Illuminate\Database\Eloquent\Model;
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
        if(is_string($queryOrModel)) {
            $queryOrModel = app($queryOrModel);
        }
        if($queryOrModel instanceof Closure) {
            $queryOrModel = $this->evaluate($queryOrModel);
        }

        // Attempt to always get a query builder
        return $queryOrModel instanceof Builder ? $queryOrModel : $queryOrModel->query();
    }

    protected function dispatchAction():void
    {

    }

    public function response(Builder|Model|string|Closure $queryOrModel = null): DatatableResource
    {
        // Attempt to always get a query builder
        $baseQuery = $this->resolveQueryOrModel($queryOrModel);

        // Get the columns defined
        $columns = $this->getColumns();

        // Get the filters
        $filters = $this->getFilters();

        $paginator = User::search(
            request()->get('search') ?? '',
            function (Builder $query) use($columns, $filters, $baseQuery) {
                $query
                    // Select columns
                    ->select(array_keys($columns->toArray()))

                    // Merge previous query
                    ->mergeConstraintsFrom($baseQuery)

                    // Perform sorting
                    ->when(!empty(request()->input('sorting')), function (Builder|ScoutBuilder $subQuery) use($columns) {
                        // Each column that needs to be sorted
                        collect(request()->input('sorting'))
                            // Filter the ones not present in the columns
                            ->filter(function($sorting) use($columns){
                                if(empty($sorting)){
                                    return false;
                                }
                                /** @var Column $column */
                                $column = $columns?->first(fn($item,$key) => $key === $sorting['column']);
                                if(empty($column)){
                                    return false;
                                }
                                return $column->isSortable();
                            })
                            // Apply Sorting
                            ->each(fn ($sorting)  => $subQuery->orderBy($sorting['column'], $sorting['direction']));
                        return $subQuery;
                    })

                    // Filters
                    ->when(!empty(request()->input('filters')), function (Builder|ScoutBuilder $subQuery) use($filters) {
                        // Each column that needs to be sorted
                        collect(request()->input('filters'))
                            // Filter the ones not present in the columns
                            ->filter(fn($filterValue,$filterKey) => $filterValue !== null && $filters?->first(fn($item,$key) => $key === $filterKey))

                            // Apply Sorting
                            ->each(function ($filterValue,$filterKey) use($subQuery,$filters) {
                                $filter = $filters?->first(fn($item,$key) => $key === $filterKey);
                                if($filter instanceof Filter){
                                    $filter->apply($subQuery,$filterKey,$filterValue);
                                }
                            });
                        return $subQuery;
                    });

                $this->query = $query->clone();
                return $query;
            }
        )
        ->paginate();

        ray(request()->all());

        return (new DatatableResource($paginator))->rightSideMaximumPages(3);
    }
}
