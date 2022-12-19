<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

trait HasTranslations
{
    /** @var array */
    protected array $translations = [];

    protected function getDefaultTranslations(): array
    {
        return [
            'title' => trans('vanilla-components::translations.datatables.title'),
            'subtitle' => trans('vanilla-components::translations.datatables.subtitle'),
            'resource' => trans('vanilla-components::translations.datatables.resource'),
            'resources' => trans('vanilla-components::translations.datatables.resources'),

            'actionsButton' => trans('vanilla-components::translations.datatables.actionsButton'),
            'actionsSelectedRows' => trans('vanilla-components::translations.datatables.actionsSelectedRows'),

            'actionConfirmTitle' => trans('vanilla-components::translations.datatables.actionConfirmTitle'),
            'actionConfirmText' => trans('vanilla-components::translations.datatables.actionConfirmText'),
            'actionConfirmButton' => trans('vanilla-components::translations.datatables.actionConfirmButton'),
            'actionCancelButton' => trans('vanilla-components::translations.datatables.actionCancelButton'),

            'search' => trans('vanilla-components::translations.datatables.search'),
            'searchPlaceholder' => trans('vanilla-components::translations.datatables.searchPlaceholder'),

            'selectRows' => trans('vanilla-components::translations.datatables.selectRows'),
            'selectedUndo' => trans('vanilla-components::translations.datatables.selectedUndo'),
            'selectAllOr' => trans('vanilla-components::translations.datatables.selectAllOr'),
            'selectAllMatching' => trans('vanilla-components::translations.datatables.selectAllMatching'),
            'selectAllMatchingUndo' => trans('vanilla-components::translations.datatables.selectAllMatchingUndo'),

            'filters' => trans('vanilla-components::translations.datatables.filters'),
            'filtersBarLabel' => trans('vanilla-components::translations.datatables.filtersBarLabel'),
            'filtersWithEmptyData' => trans('vanilla-components::translations.datatables.filtersWithEmptyData'),
            'filtersReset' => trans('vanilla-components::translations.datatables.filtersReset'),
            'filtersResetOr' => trans('vanilla-components::translations.datatables.filtersResetOr'),
            'filtersCopy' => trans('vanilla-components::translations.datatables.filtersCopy'),
            'filtersCopied' => trans('vanilla-components::translations.datatables.filtersCopied'),
            'filtersSaveAndClose' => trans('vanilla-components::translations.datatables.filtersSaveAndClose'),
            'filtersRemove' => trans('vanilla-components::translations.datatables.filtersRemove'),

            'settings' => trans('vanilla-components::translations.datatables.settings'),
            'settingsItemsPerPage' => trans('vanilla-components::translations.datatables.settingsItemsPerPage'),
            'settingsVisibility' => trans('vanilla-components::translations.datatables.settingsVisibility'),
            'settingsPersist' => trans('vanilla-components::translations.datatables.settingsPersist'),
            'settingsPersistSelection' => trans('vanilla-components::translations.datatables.settingsPersistSelection'),
            'settingsReset' => trans('vanilla-components::translations.datatables.settingsReset'),
            'settingsSaveAndClose' => trans('vanilla-components::translations.datatables.settingsSaveAndClose'),

            'refresh' => trans('vanilla-components::translations.datatables.refresh'),

            'recordsEmpty' => trans('vanilla-components::translations.datatables.recordsEmpty'),
            'recordsEmptyWithFiltersOrSearch' => trans('vanilla-components::translations.datatables.recordsEmptyWithFiltersOrSearch'),
            'recordsEmptyWithFiltersOrSearchAction' => trans('vanilla-components::translations.datatables.recordsEmptyWithFiltersOrSearchAction'),

            'settingsPerPage' => trans('vanilla-components::translations.datatables.settingsPerPage'),
            'selectOption' => trans('vanilla-components::translations.placeholder-select'),

            'showingFrom' => trans('vanilla-components::translations.datatables.showingFrom'),
            'nextPage' => trans('vanilla-components::translations.datatables.nextPage'),
            'previousPage' => trans('vanilla-components::translations.datatables.previousPage'),


        ];
    }

    protected function mergeTranslations(array $translations = []): array
    {
        return array_merge($this->getDefaultTranslations(), $translations);
    }

    public function translations(): array
    {
        return $this->getDefaultTranslations();
    }

    protected function setupTranslations(): void
    {
        $this->translations = $this->translations();
    }

    protected function translationsToArray(): array
    {
        return collect($this->translations)->toArray();
    }
}
