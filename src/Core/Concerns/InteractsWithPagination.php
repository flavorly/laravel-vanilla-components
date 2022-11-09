<?php

namespace VanillaComponents\Core\Concerns;

trait InteractsWithPagination
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
}
