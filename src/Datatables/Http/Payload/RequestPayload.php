<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload;

use Flavorly\VanillaComponents\Core\Concerns\Makable;
use Flavorly\VanillaComponents\Datatables\Concerns\BelongsToTable;
use Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class RequestPayload
{
    use Concerns\CanBeFiltered;
    use Concerns\CanBeSorted;
    use Concerns\CanSelectAllRows;
    use Concerns\HasAction;
    use Concerns\HasDatatableQuery;
    use Concerns\HasModels;
    use Concerns\HasPerPage;
    use Concerns\HasSearch;
    use Concerns\HasSelectedRows;
    use BelongsToTable;
    use Makable;

    public function __construct()
    {
        $this->filters = collect();
        $this->sorting = collect();
        $this->isAllSelected = false;
        $this->action = null;
        $this->query = null;
        $this->models = EloquentCollection::make();
        $this->perPage = 10;
        $this->selectedRowsIds = collect();
    }

    public function fromRequest(): static
    {
        $this->withFilters(collect(request('filters', [])));
        $this->withSorting(collect(request('sorting', [])));
        $this->withIsAllSelected(request('selectedAll', false));
        $this->withAction(request('action'));
        $this->withPerPage(request('perPage', 10));
        $this->withSelectedRowsIds(collect(request('selected', [])));
        return $this;
    }
}
