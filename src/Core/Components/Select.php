<?php

namespace Flavorly\VanillaComponents\Core\Components;

class Select extends BaseComponent
{
    use Concerns\HasOptions;

    protected string $component = 'VanillaSelect';

    public function toArray(): array
    {
        if (empty($this->getPlaceholder())) {
            $this->placeholder(trans('vanilla-components::translations.placeholder-select'));
        }

        return array_merge(parent::toArray(), [
            'options' => $this->getOptionsToArray(),
        ]);
    }
}
