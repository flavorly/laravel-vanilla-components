<?php

namespace VanillaComponents\Datatables\Concerns;

use VanillaComponents\Core\Polling\Polling;

trait HasPolling
{
    /** @var array */
    protected array $pollingOptions = [];

    public function polling(): array | Polling
    {
        return Polling::make();
    }

    protected function setupPolling(): void
    {
        $pollingOptions = $this->polling();
        $this->pollingOptions = $pollingOptions instanceof Polling ? $pollingOptions->toArray() : $pollingOptions;
    }

    protected function pollingToArray(): array
    {
        return collect($this->pollingOptions)->toArray();
    }
}
