<?php

namespace VanillaComponents\Datatables\Concerns;

use Illuminate\Support\Collection;
use VanillaComponents\Datatables\Options\Page\PerPageOption;

trait HasPageOptions
{
    protected array $perPageOptions = [];

    protected array $perPageDefault = [5, 10, 50, 100, 200];

    /**
     * @return PerPageOption[]
     */
    public function perPageOptions(): array
    {
        $options = [];
        foreach ($this->perPageDefault as $index => $value) {
            $options[] = PerPageOption::make()
                ->value($value)
                ->label(trans(':count Item(s) p/ page', ['count' => $value]))
                ->default(fn () => $index === 0);
        }

        return $options;
    }

    public function getPerPageOptions(): Collection
    {
        if (empty($this->perPageOptions())) {
            return collect();
        }

        return collect($this->perPageOptions())
            ->mapWithKeys(function ($perPageOption) {
                if (is_string($perPageOption)) {
                    $perPageOption = app($perPageOption);
                    return [$perPageOption->getValue() => $perPageOption];
                }

                if (! $perPageOption instanceof PerPageOption) {
                    return [];
                }

                return [$perPageOption->getValue() => $perPageOption];
            })
            ->filter(fn ($perPageOption) => ! empty($perPageOption));
    }

    protected function setupPerPageOptions(): void
    {
        $this->perPageOptions = $this->perPageOptions();
    }

    protected function perPageOptionsToArray(): array
    {
        if (! empty($this->perPageOptions)) {
            return collect($this->perPageOptions)
                ->map(function ($option) {
                    if ($option instanceof PerPageOption) {
                        return $option->toArray();
                    }
                    if (is_array($option)) {
                        return $option;
                    }

                    return [];
                })
                ->filter(fn ($option) => ! empty($option))
                ->toArray();
        }

        return [];
    }
}