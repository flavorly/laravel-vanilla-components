<?php

namespace Flavorly\VanillaComponents\Datatables\PendingAction\Concerns;

use Closure;
use Illuminate\Support\Collection;

trait HasCollectionOfRows
{
    protected ?Collection $rows = null;

    public function rows(Collection | Closure | null $rows): static
    {
        $this->rows = $rows;

        return $this;
    }

    public function getRows(): Collection
    {
        return $this->evaluate($this->rows || collect());
    }
}
