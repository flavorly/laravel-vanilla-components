<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Resources;

use Closure;
use Flavorly\VanillaComponents\Core\Concerns\InteractsWithPagination;
use Flavorly\VanillaComponents\Datatables\Paginator\PaginatedResourceResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DatatableResource extends ResourceCollection
{
    use InteractsWithPagination;

    protected ?Closure $transformUsing = null;

    public function toArray($request): array
    {
        if (null !== $this->transformUsing) {
            $this->collection = $this
                ->collection
                ->map($this->transformUsing)
                ->map(function ($item) {
                    return collect($item)->map(function ($value, $key) {
                        return $value instanceof Closure ? $value() : $value;
                    })
                    ->toArray();
                });
        }

        return [
            'data' => $this->collection,
        ];
    }

    public function transformResponseUsing(Closure $callback)
    {
        $this->transformUsing = $callback;

        return $this;
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
