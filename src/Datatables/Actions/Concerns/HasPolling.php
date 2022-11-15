<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Flavorly\VanillaComponents\Core\Polling\Polling;
use Illuminate\Support\Arr;

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
