<?php

namespace VanillaComponents\Datatables\Options\General\Concerns;

use Closure;

trait CanShowDetailedPagination
{
    protected bool | Closure $showTotalNumberOfItems = true;

    protected bool | Closure $showCurrentPage = true;

    protected bool | Closure $showNextPages = true;

    protected bool | Closure $showPages = false;

    public function showTotalNumberOfItems(bool | Closure $condition = true): static
    {
        $this->showTotalNumberOfItems = $condition;

        return $this;
    }

    public function showCurrentPage(bool | Closure $condition = true): static
    {
        $this->showCurrentPage = $condition;

        return $this;
    }

    public function showNextPages(bool | Closure $condition = true): static
    {
        $this->showNextPages = $condition;

        return $this;
    }

    public function showPages(bool | Closure $condition = true): static
    {
        $this->showPages = $condition;

        return $this;
    }

    public function isTotalNumberOfItemsVisible(): bool
    {
        return $this->evaluate($this->showTotalNumberOfItems);
    }

    public function isCurrentPageVisible(): bool
    {
        return $this->evaluate($this->showCurrentPage);
    }

    public function isNextPagesVisible(): bool
    {
        return $this->evaluate($this->showNextPages);
    }

    public function isShowingPages(): bool
    {
        return $this->evaluate($this->showPages);
    }
}
