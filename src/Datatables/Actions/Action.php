<?php

namespace VanillaComponents\Datatables\Actions;

use Illuminate\Support\Traits\Macroable;
use VanillaComponents\Core\Concerns as CoreConcerns;
use VanillaComponents\Core\Confirmation\Confirmation;
use VanillaComponents\Core\Contracts as CoreContracts;
use VanillaComponents\Core\Polling\Polling;
use VanillaComponents\Datatables\Concerns as BaseConcerns;

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
    use Concerns\HasPermissions;
    use Concerns\HasHooks;
    use Concerns\CanBeExecuted;
    use Concerns\CanClearSelected;
    use Concerns\CanBeConfirmed;
    use Concerns\CanResetFilters;
    use Macroable;

    public function __construct()
    {
        $this->setup();
        $this->ensureDefaults();
    }

    protected function setup()
    {
        // Nothing in here, override to add your own setup
    }

    protected function ensureDefaults()
    {
        // Polling
        $polling = Polling::make()->enabled(false);

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

        // Other stuff
        $this->after['clearSelected'] = $this->getShouldClearSelectionAfterAction() ?? true;
        $this->after['resetFilters'] = $this->getShouldClearFiltersAfterAction() ?? false;
        $this->after['polling'] = $this->getPolling() ?? $polling;
        $this->before['confirm'] = $this->getConfirmation() ?? $confirmation;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'permissions' => $this->getPermissionsToArray(),
            'fields' => collect($this->getFields())->map->toArray()->toArray(),
            'before' => $this->getBeforeToArray(),
            'after' => $this->getAfterToArray(),
        ];
    }
}
