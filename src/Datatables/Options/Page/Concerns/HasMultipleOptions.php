<?php

namespace VanillaComponents\Datatables\Options\Page\Concerns;

use VanillaComponents\Datatables\Options\Page\PerPageOption;

trait HasMultipleOptions
{
    protected array $options = [];

    protected array $defaultOptionsValues = [5, 10, 50, 100, 200];

    public function options(): array
    {
        $options = [];
        foreach ($this->defaultOptionsValues as $index => $value) {
            $options[] = PerPageOption::make()
                ->value($value)
                ->label($value)
                ->default(fn () => $index === 0);
        }

        return $options;
    }
}
