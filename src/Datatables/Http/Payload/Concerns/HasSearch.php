<?php

namespace Flavorly\VanillaComponents\Datatables\Http\Payload\Concerns;

trait HasSearch
{
    /**
     * Stores the search query
     *
     * @var string
     */
    protected string $search = '';

    public function withSearch(string $search): static
    {
        $this->search = $search;

        return $this;
    }

    public function getSearch(): string
    {
        return $this->search ?? '';
    }

    public function hasSearch(): bool
    {
        return ! empty($this->search);
    }
}
