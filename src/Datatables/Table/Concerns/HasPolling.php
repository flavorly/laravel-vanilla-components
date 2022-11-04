<?php

namespace VanillaComponents\Datatables\Table\Concerns;

use VanillaComponents\Core\Polling\PollingOptions;

trait HasPolling
{
    /** @var array */
    protected array $poolingOptions = [];

    public function polling(): array | PollingOptions
    {
        return PollingOptions::make();
    }

    protected function setupPolling(): void
    {
        $pollingOptions = $this->polling();
        $this->poolingOptions = $pollingOptions instanceof PollingOptions ? $pollingOptions->toArray() : $pollingOptions;
    }

    protected function pollingToArray(): array
    {
        return collect($this->poolingOptions)->toArray();
    }
}
