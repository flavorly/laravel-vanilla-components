<?php

namespace VanillaComponents\Datatables\Actions\Concerns;

use Illuminate\Support\Arr;
use VanillaComponents\Core\Polling\PollingOptions;

trait HasPolling
{
    public function polling(PollingOptions|null $pollingOptions = null): static
    {
        $this->after['polling'] = $pollingOptions;
        return $this;
    }

    protected function getPolling(): null|PollingOptions
    {
        return $this->evaluate(Arr::get($this->after,'polling'));
    }
}
