<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use Flavorly\VanillaComponents\Datatables\Options\Page\PerPageOption;
use Illuminate\Support\Collection;

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
                ->label(trans('vanilla-components::translations.datatables.settingsPerPage',['count' => $value]))
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

    public function getPerPageOptionByNumber(int|string|null $perPageOption = null): PerPageOption
    {
        return $this->getPerPageOptions()->first(fn ($item, $key) => $key === $perPageOption) ?? $this->getPerPageOptions()->first();
    }

    protected function setupPerPageOptions(): void
    {
        $this->perPageOptions = $this->perPageOptions();
    }

    protected function perPageOptionsToArray(): array
    {
        return $this->getPerPageOptions()->map(fn ($option) => $option->toArray())->values()->toArray();
    }
}
