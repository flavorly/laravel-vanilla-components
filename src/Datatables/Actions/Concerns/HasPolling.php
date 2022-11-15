<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Illuminate\Support\Arr;
use Flavorly\VanillaComponents\Core\Polling\Polling;

trait HasPolling
{
    public function polling(Polling|null $pollingOptions = null): static
    {
        $this->after['polling'] = $pollingOptions;

        return $this;
    }

    protected function getPolling(): null|Polling
    {
        return $this->evaluate(Arr::get($this->after, 'polling'));
    }
}
