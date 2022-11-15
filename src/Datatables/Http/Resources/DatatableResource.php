<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Resources;

use Flavorly\VanillaComponents\Core\Concerns\InteractsWithPagination;
use Flavorly\VanillaComponents\Datatables\Paginator\PaginatedResourceResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DatatableResource extends ResourceCollection
{
    use InteractsWithPagination;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }

    protected function preparePaginatedResponse($request)
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (! is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new PaginatedResourceResponse($this))
            ->leftSideMaximumPages($this->leftSideMaximumPages, $this->leftSideMaximumPagesOnLong)
            ->rightSideMaximumPages($this->rightSideMaximumPages, $this->rightSideMaximumPagesOnLong)
            ->centerMaximumPages($this->rightSideMaximumPages, $this->rightSideMaximumPagesOnLong)
            ->toResponse($request);
    }
}
