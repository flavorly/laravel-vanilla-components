<?php

namespace VanillaComponents\Datatables\Table\Concerns;

use VanillaComponents\Datatables\Options\General\Options;

trait HasOptions
{
    /** @var array */
    protected array $options = [];

    public function options(): array | Options
    {
        return Options::make()->toArray();
    }

    protected function setupOptions(): void
    {
        $options = $this->options();
        $this->options = $options instanceof Options ? $options->toArray() : $options;
    }

    protected function optionsToArray(): array
    {
        return collect($this->options)->toArray();
    }
}
