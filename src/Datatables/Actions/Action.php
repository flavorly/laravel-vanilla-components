<?php

namespace VanillaComponents\Datatables\Actions;

use VanillaComponents\Core\Confirmation\Confirmation;
use VanillaComponents\Core\Contracts as CoreContracts;
use VanillaComponents\Core\Polling\PollingOptions;
use VanillaComponents\Datatables\Actions\Concerns;
use VanillaComponents\Datatables\Concerns as BaseConcerns;
use VanillaComponents\Core\Concerns as CoreConcerns;

class Action implements CoreContracts\HasToArray
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use BaseConcerns\BelongsToTable;
    use BaseConcerns\BelongsToTable;
    use Concerns\HasName;
    use Concerns\HasLabel;
    use Concerns\HasFields;
    use Concerns\HasBefore;
    use Concerns\HasAfter;
    use Concerns\HasPolling;
    use Concerns\CanClearSelected;
    use Concerns\CanBeConfirmed;
    use Concerns\CanResetFilters;

    protected function ensureDefaults()
    {
        // Polling
        $polling =  PollingOptions::make()->enabled(false);

        // Default
        $confirmation = Confirmation::make()
            ->enabled()
            ->buttons(
                trans('vanilla-components-laravel::translations.confirmation.confirm'),
                trans('vanilla-components-laravel::translations.confirmation.cancel'),
            )
            ->raw(false)
            ->title($this->getName())
            ->text(trans('vanilla-components-laravel::translations.confirmation.text'));

        $this->after['clearSelected'] = $this->getShouldClearSelectionAfterAction() ?? true;
        $this->after['resetFilters'] = $this->getShouldClearFiltersAfterAction() ?? false;
        $this->after['polling'] = $this->getPolling() ?? $polling;
        $this->before['confirm'] = $this->getConfirmation() ?? $confirmation;
    }

    public function toArray(): array
    {
       $this->ensureDefaults();

       return [
           'name' => $this->getName(),
           'label' => $this->getLabel(),
           'permissions' => [],
           'fields' => collect($this->getFields())->map->toArray()->toArray(),
           'before' => $this->getBeforeToArray(),
           'after' => $this->getAfterToArray(),
       ];
    }
}
