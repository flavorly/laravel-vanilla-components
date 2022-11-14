<?php

namespace VanillaComponents\Datatables\Concerns;

trait HasTranslations
{
    /** @var array */
    protected array $translations = [];

    public function translations(): array
    {
        return [];
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
