<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

trait HasTranslations
{
    /** @var array */
    protected array $translations = [];

    protected function getDefaultTranslations(): array
    {
        return [
            'title' => 'Items',
            'subtitle' => 'Here you can check your latest items',
            'resource' => 'Item',
            'resources' => 'Items',

            'actionsButton' => 'Actions',
            'actionsSelectedRows' => 'With =>rows selected',

            'actionConfirmTitle' => 'Confirm your action',
            'actionConfirmText' => 'Are you sure you want to =>action on the =>itemsSelected item(s) selected? Please confirm',
            'actionConfirmButton' => 'Yes, I\'v Confirmed',
            'actionCancelButton' => 'Nah, Cancel',

            'search' => 'Search',
            'searchPlaceholder' => 'Search your latest Payments',

            'selectRows' => 'You currently have =>rows payments selected',
            'selectedUndo' => 'Deselect all',
            'selectAllOr' => 'Select current page or',
            'selectAllMatching' => 'Select all records matching filter',
            'selectAllMatchingUndo' => 'Select only current page',

            'filters' => 'Filters',
            'filtersBarLabel' => 'Filters',
            'filtersWithEmptyData' => 'Oops, seems like there is no records after filtering',
            'filtersReset' => 'Reset Filters',
            'filtersResetOr' => 'or',
            'filtersCopy' => 'Copy Filters Link',
            'filtersCopied' => 'Copied to Clipboard',
            'filtersSaveAndClose' => 'Save & Close',
            'filtersRemove' => 'Remove',

            'settings' => 'Settings',
            'settingsItemsPerPage' => 'Items p/ Page',
            'settingsVisibility' => 'Visibility',
            'settingsPersist' => 'Persist Settings',
            'settingsPersistSelection' => 'Save Selected',
            'settingsReset' => 'Reset to Default Settings',
            'settingsSaveAndClose' => 'Save & Close',

            'refresh' => 'Refresh',

            'recordsEmpty' => 'Seems like there is no records to show you. Please come back later or try inserting some records.',
            'recordsEmptyWithFiltersOrSearch' => 'Sorry but there is no records matching your search or filters.',
            'recordsEmptyWithFiltersOrSearchAction' => 'Reset Query',

            'settingsPerPage' => '=>count Items per page',

            'showingFrom' => 'Showing =>from to =>to of =>total results',
            'nextPage' => 'Next',
            'previousPage' => 'Previous',
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
