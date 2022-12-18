<?php

namespace Flavorly\VanillaComponents\Datatables\Columns\Concerns;

use Illuminate\Support\Str;

trait CanBeSelected
{
    public function selectable(): bool
    {
        return ! Str::of($this->getName())->contains('.');
    }
}
