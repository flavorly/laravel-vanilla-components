<?php

namespace Flavorly\VanillaComponents\Core\Components\Concerns;

use Closure;

trait CanBeSearchable
{
    protected array|Closure $searchableTranslations = [
        'searchBoxPlaceholder' => 'Write your search query here with 3 minimum characters',
        'noResultsText' => 'Sorry but we could not find any results for your search',
        'searchingText' => 'Loading... please wait',
        'loadingClosedPlaceholder' => 'Loading... please wait',
        'loadingMoreResultsText' => 'Loading more results...',
    ];

    public function searchableTranslations(array|Closure $translations = null): static
    {
        $this->searchableTranslations = $translations;

        return $this;
    }

    public function getSearchableTranslations(): mixed
    {
        return $this->evaluate($this->searchableTranslations);
    }
}
