<?php

namespace Flavorly\VanillaComponents\Datatables\Actions;

use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Core\Confirmation\Confirmation;
use Flavorly\VanillaComponents\Core\Contracts as CoreContracts;
use Flavorly\VanillaComponents\Core\Polling\Polling;
use Flavorly\VanillaComponents\Datatables\Concerns as BaseConcerns;
use Illuminate\Support\Traits\Macroable;

class Action implements CoreContracts\HasToArray
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use BaseConcerns\BelongsToTable;
    use Concerns\HasName;
    use Concerns\HasLabel;
    use Concerns\HasFields;
    use Concerns\HasBefore;
    use Concerns\HasAfter;
    use Concerns\HasPolling;
    use Concerns\HasPermissions;
    use Concerns\HasHooks;
    use Concerns\HasPayload;
    use Concerns\CanBeExecuted;
    use Concerns\CanClearSelected;
    use Concerns\CanBeConfirmed;
    use Concerns\CanResetFilters;
    use Concerns\CanBeConvertedToModels;
    use Concerns\CanRefresh;
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
                trans('laravel-vanilla-components::translations.confirmation.confirm'),
                trans('laravel-vanilla-components::translations.confirmation.cancel'),
            )
            ->raw(false)
            ->title($this->getName())
            ->text(trans('laravel-vanilla-components::translations.confirmation.text'));

        // Other stuff
        $this->after['clearSelected'] = $this->getShouldClearSelectionAfterAction() ?? true;
        $this->after['resetFilters'] = $this->getShouldClearFiltersAfterAction() ?? false;
        $this->after['polling'] = $this->getPolling() ?? $polling;
        $this->before['confirm'] = $this->getConfirmation() ?? $confirmation;
        $this->before['refresh'] = $this->getShouldRefreshAfterExecuted() ?? true;
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
