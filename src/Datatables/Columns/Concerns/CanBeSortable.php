<?php

namespace Flavorly\VanillaComponents\Datatables\Columns\Concerns;

use Closure;
use Illuminate\Support\Str;

trait CanBeSortable
{
    protected bool|Closure $isSortable = false;

    protected ?array $sortColumns = [];

    protected ?string $sortDirection = null;

    public function sortable(bool|array $condition = true, ?Closure $applySortUsing = null): static
    {
        if (is_array($condition)) {
            $this->isSortable = true;
            $this->sortColumns = $condition;
        } else {
            $this->isSortable = $condition;
            $this->sortColumns = null;
        }

        if(null !== $applySortUsing){
            $this->sortUsing($applySortUsing);
        }

        return $this;
    }

    public function sortedAs(string $direction): static
    {
        if (! in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }
        $this->sortDirection = $direction;

        return $this;
    }

    public function getSortDirection(): ?string
    {
        return $this->sortDirection;
    }

    public function getSortColumns(): array
    {
        return $this->sortColumns ?? $this->getDefaultSortColumns();
    }

    public function isSortable(): bool
    {
        return $this->isSortable;
    }

    protected function getDefaultSortColumns(): array
    {
        return [Str::of($this->getName())->afterLast('.')];
    }
}
