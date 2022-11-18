<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use App\Models\User;
use Closure;
use Flavorly\VanillaComponents\Datatables\Data\DatatableRequest;
use Flavorly\VanillaComponents\Datatables\Filters\Filter;
use Flavorly\VanillaComponents\Datatables\Http\Resources\DatatableResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Builder as ScoutBuilder;

trait InteractsWithQueryBuilder
{
    protected Builder|ScoutBuilder|null $query = null;

    protected DatatableRequest $data;

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
        // Get the actions
        $action = $this->getActionByKey($this->data->action);
        if (! $action) {
            return;
        }

        $action->execute($this->data);
    }

    public function response(Builder $queryOrModel, DatatableRequest $data): DatatableResource
    {
        // Flash the initial data
        $this->data = $data;

        // Attempt to always get a query builder
        $baseQuery = $this->resolveQueryOrModel($queryOrModel);

        $paginator = User::search(
            $this->data->search ?? '',

            // We use scout for searching, the second argument we can modify the underlying query, so that we will be able to
            // Control the actual results, the base query constraints are merged into this.

            function (Builder $query) use ($baseQuery) {
                $query
                    // Select columns
                    ->select($this->getColumnKeys()->toArray())

                    // Merge previous query
                    ->mergeConstraintsFrom($baseQuery)

                    // Perform sorting
                    ->when($this->data->sorting->isNotEmpty(), function (Builder|ScoutBuilder $subQuery) {
                        // Each column that needs to be sorted
                        $this
                            ->data
                            ->sorting
                            // Filter the ones not present in the columns
                            ->filter(function ($sorting) {
                                if (empty($sorting)) {
                                    return false;
                                }
                                $column = $this->getColumnByKey($sorting['column']);
                                if (! $column) {
                                    return false;
                                }

                                return $column->isSortable();
                            })

                            // Apply Sorting
                            ->each(fn ($sorting) => $subQuery->orderBy($sorting['column'], $sorting['direction']));

                        return $subQuery;
                    })

                    // Filters
                    ->when($this->data->filters->isNotEmpty(), function (Builder|ScoutBuilder $subQuery) {
                        // Each column that needs to be sorted
                        $this
                            ->data
                            ->filters
                            // Filter the ones not present in the columns
                            ->filter(fn ($filterValue, $filterKey) => $filterValue !== null && $this->getFilterByKey($filterKey) !== null)

                            // Apply Sorting
                            ->each(function ($filterValue, $filterKey) use ($subQuery) {
                                $filter = $this->getFilterByKey($filterKey);
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
        ->paginate($this->getPerPageOptionByNumber($this->data->perPage)->getValue());

        // Re-flash the data with the query that is already merged.
        $this->data = DatatableRequest::from(array_merge($data->toArray(), ['query' => $this->query]));

        // Only execute if there is an action and selectedAll is true or selected is not empty
        if ($this->data->action && ($this->data->isAllSelected === true || $this->data->selectedRowsIds->isNotEmpty())) {
            $this->dispatchAction();
        }

        return (new DatatableResource($paginator))->rightSideMaximumPages(3);
    }
}
