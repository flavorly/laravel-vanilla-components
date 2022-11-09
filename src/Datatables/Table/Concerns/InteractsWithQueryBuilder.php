<?php

namespace VanillaComponents\Datatables\Table\Concerns;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use VanillaComponents\Datatables\Http\Resources\DatatableResource;

trait InteractsWithQueryBuilder
{
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
        $baseQuery = $queryOrModel instanceof Builder ? $queryOrModel : $queryOrModel->query();
        return $baseQuery;
    }

    public function response(Builder|Model|string|Closure $queryOrModel = null)
    {
        // Attempt to always get a query builder
        $baseQuery = $this->resolveQueryOrModel($queryOrModel);

        // Get the columns defined
        $columns = collect($this->columns())->map(fn($column) => $column->getName());

        // Get the filters
        $filters = collect($this->filters())->map(fn($filter) => $filter->getName());

        ray($filters,request()->all());

        $paginator = User::search(
            request()->get('search') ?? '',
            fn(Builder $query) =>
            $query
                // Select columns
                ->select($columns->toArray())

                // Merge previous query
                ->mergeConstraintsFrom($baseQuery)

                // Perform sortings
                ->when(!empty(request()->input('sorting')), function (Builder|\Laravel\Scout\Builder $subQuery) use($columns) {
                    // Each column that needs to be sorted
                    collect(request()->input('sorting'))
                        // Filter the ones not present in the columns
                        ->filter(fn($sorting) => !empty($sorting['column']) && $columns->contains($sorting['column']))
                        // Apply Sorting
                        ->each(fn ($sorting)  => $subQuery->orderBy($sorting['column'], $sorting['direction']));
                    return $subQuery;
                })

                // Filters
                ->when(!empty(request()->input('filters')), function (Builder|\Laravel\Scout\Builder $subQuery) use($filters) {
                    // Each column that needs to be sorted
                    collect(request()->input('filters'))
                        // Filter the ones not present in the columns
                        ->filter(fn($filterValue,$filterKey) => $filterValue !== null && $filters->contains($filterKey))
                        // Apply Sorting
                        ->each(function ($filterValue,$filterKey) use($subQuery) {
                            rd($this->filters());
                            collect($this->filters())->where('name',$filterKey)->first()->apply($subQuery,$filterKey,$filterValue);
                        });
                    return $subQuery;
                })
        )
        ->paginate();

        return (new DatatableResource($paginator))->rightSideMaximumPages(3);
    }
}
