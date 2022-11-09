<?php

namespace VanillaComponents\Datatables\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use VanillaComponents\Datatables\Paginator\PaginatedResourceResponse;

class DatatableResource extends ResourceCollection
{
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

        return (new PaginatedResourceResponse($this))->toResponse($request);
    }
}
