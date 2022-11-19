<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use App\Models\User;
use Closure;
use Flavorly\VanillaComponents\Datatables\Columns\Column;
use Flavorly\VanillaComponents\Datatables\Filters\Filter;
use Flavorly\VanillaComponents\Datatables\Http\Payload\RequestPayload;
use Flavorly\VanillaComponents\Datatables\Http\Resources\DatatableResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Builder as ScoutBuilder;

trait InteractsWithQueryBuilder
{
    protected Builder|ScoutBuilder|null $query = null;

    protected RequestPayload $data;

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
        if (
            $this->data->hasAction() &&
            ($this->data->isAllSelected() || $this->data->hasSelectedRows())
        ) {
            // Execute the action
            $this->data->getAction()->execute();
        }
    }

    public function response(Builder $queryOrModel): DatatableResource
    {
        // Create the data from the request payload
        // First we need to infer the table.
        $this->data = RequestPayload::make()
            ->table($this)
            ->fromRequest();

        // Attempt to always get a query builder
        $baseQuery = $this->resolveQueryOrModel($queryOrModel);

        $paginator = User::search(

            $this->data->getSearch(),
            // We use scout for searching, the second argument we can modify the underlying query, so that we will be able to
            // Control the actual results, the base query constraints are merged into this.

            function (Builder $query) use ($baseQuery) {
                $query
                    // Select columns
                    ->select($this->getColumnKeys()->toArray())

                    // Merge previous query
                    ->mergeConstraintsFrom($baseQuery)

                    // Perform sorting
                    ->when($this->data->hasSorting(), function (Builder|ScoutBuilder $subQuery) {
                        // Each column that needs to be sorted
                        $this
                            ->data
                            ->getSorting()
                            ->each(fn (Column $column) => $subQuery->orderBy(
                                $column->getName(),
                                $column->getSortDirection()
                            )
                            );

                        return $subQuery;
                    })

                    // Filters
                    ->when($this->data->hasFilters(), function (Builder|ScoutBuilder $subQuery) {
                        // Each column that needs to be sorted
                        $this
                            ->data
                            ->getFilters()
                            // Apply Sorting
                            ->each(fn (Filter $filter) => $filter->apply(
                                $subQuery,
                                $filter->getName(),
                                $filter->getValue()
                            )
                            );

                        return $subQuery;
                    });

                // Save the current query, and clone it.
                $this->query = $query->clone();

                return $query;
            }
        )
        ->paginate($this->data->getPerPage());

        // Append the query, because at this point we are done with it.
        $this->data->withQuery($this->query);

        // Dispatch the action
        $this->dispatchAction();

        return (new DatatableResource($paginator))->rightSideMaximumPages(3);
    }
}
