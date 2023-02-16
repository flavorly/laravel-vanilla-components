<?php

namespace Flavorly\VanillaComponents\Core\Components;

class RichSelect extends BaseComponent
{
    use Concerns\CanBeSearchable;
    use Concerns\HasOptions;
    use Concerns\HasFetchOptions;

    protected string $component = 'VanillaRichSelect';

    public function toArray(): array
    {
        // Set the default translations
        $this->searchableTranslations([
            'searchBoxPlaceholder' => trans('laravel-vanilla-components::translations.select.searchBoxPlaceholder'),
            'noResultsText' => trans('laravel-vanilla-components::translations.select.noResultsText'),
            'searchingText' => trans('laravel-vanilla-components::translations.select.searchingText'),
            'loadingClosedPlaceholder' => trans('laravel-vanilla-components::translations.select.loadingClosedPlaceholder'),
            'loadingMoreResultsText' => trans('laravel-vanilla-components::translations.select.loadingMoreResultsText'),
        ]);

        return array_merge(
            // Base
            parent::toArray(),
            // Options
            [
                'options' => $this->getOptionsToArray(),
            ],
            // Fetch Stuff
            $this->getFetchOptionsEndpoint() !== null ? [
                'fetchEndpoint' => $this->getFetchOptionsEndpoint(),
                'valueAttribute' => $this->getFetchOptionKey(),
                'textAttribute' => $this->getFetchOptionLabel(),
            ] : []
        );
    }
}
