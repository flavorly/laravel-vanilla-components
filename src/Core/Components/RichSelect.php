<?php

namespace Flavorly\VanillaComponents\Core\Components;

class RichSelect extends BaseComponent
{
    use Concerns\CanBeSearchable;
    use Concerns\HasOptions;

    protected string $component = 'VanillaRichSelect';

    public function toArray(): array
    {
        // Set the default translations
        $this->searchableTranslations([
            'searchBoxPlaceholder' => trans('vanilla-components-laravel::translations.select.searchBoxPlaceholder'),
            'noResultsText' => trans('vanilla-components-laravel::translations.select.noResultsText'),
            'searchingText' => trans('vanilla-components-laravel::translations.select.searchingText'),
            'loadingClosedPlaceholder' => trans('vanilla-components-laravel::translations.select.loadingClosedPlaceholder'),
            'loadingMoreResultsText' => trans('vanilla-components-laravel::translations.select.loadingMoreResultsText'),
        ]);

        return array_merge(parent::toArray(), [
            'options' => $this->getOptionsToArray(),
        ]);
    }
}
