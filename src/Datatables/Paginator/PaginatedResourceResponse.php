<?php

namespace VanillaComponents\Datatables\Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse as BasePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PaginatedResourceResponse extends BasePaginator
{
    protected int $rightSideMaximumPages = 2;
    protected int $rightSideMaximumPagesOnLong = 1;
    protected int $leftSideMaximumPages = 2;
    protected int $leftSideMaximumPagesOnLong = 1;
    protected int $centerMaximumPages = 2;
    protected int $centerMaximumPagesOnLong = 3;

    public function rightSideMaximumPages(int $pages = 2, int $whenIsLongPaginated = 1): static
    {
        $this->rightSideMaximumPages = $pages;
        $this->rightSideMaximumPagesOnLong = $whenIsLongPaginated;
        return $this;
    }

    public function leftSideMaximumPages(int $pages = 1, int $whenIsLongPaginated = 1): static
    {
        $this->leftSideMaximumPages = $pages;
        $this->leftSideMaximumPagesOnLong = $whenIsLongPaginated;
        return $this;
    }

    public function centerMaximumPages(int $pages = 2, int $whenIsLongPaginated = 1): static
    {
        $this->centerMaximumPages = $pages;
        $this->centerMaximumPagesOnLong = $whenIsLongPaginated;
        return $this;
    }

    /**
     * Add the pagination information to the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function paginationInformation($request)
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
        $paginator = $this->resource->resource;
        $paginated = $this->resource->resource->toArray();

        $default = [
            'links' => [
                'pages' => $this->getCustomPaginatorLinks($paginator),
                'next' => $paginator->nextPageUrl(),
                'previous' => $paginator->previousPageUrl(),
            ],
            'meta' => $this->meta($paginated),
        ];

        if (method_exists($this->resource, 'paginationInformation')) {
            return $this->resource->paginationInformation($request, $paginated, $default);
        }

        return $default;
    }

    protected function getCustomPaginatorLinks(LengthAwarePaginator $paginator): Collection
    {

        $paginator->onEachSide = 1;
        $window = UrlWindow::make($paginator);

        $isLongPagination = is_array($window['slider']);

        // First limit the items
        $windowTruncated = collect($window)
            ->map(function ($item,$key) use($isLongPagination) {

                if($key == 'first'){
                    return collect($item)->slice(0, $isLongPagination ? $this->leftSideMaximumPagesOnLong : $this->leftSideMaximumPages)->toArray();
                }

                if($key === 'last'){
                    return collect($item)->slice(0, $isLongPagination ? $this->rightSideMaximumPagesOnLong : $this->rightSideMaximumPages)->toArray();
                }

                if($key === 'slider' && is_array($item)){
                    return collect($item)->slice(0, $isLongPagination ? $this->centerMaximumPagesOnLong : $this->centerMaximumPages)->toArray();
                }

                return $item;
            })
            ->toArray();

        $elements = array_filter([
            $windowTruncated['first'],
            is_array($windowTruncated['slider']) ? '...' : null,
            $windowTruncated['slider'],
            is_array($windowTruncated['last']) ? '...' : null,
            $windowTruncated['last'],
        ]);

        return Collection::make($elements)->flatMap(function ($item) use($paginator) {
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
    }

    /**
     * Gather the meta data for the response.
     *
     * @param  array  $paginated
     * @return array
     */
    protected function meta($paginated)
    {
        return Arr::except($paginated, [
            'data',
            'links',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
        ]);
    }
}
