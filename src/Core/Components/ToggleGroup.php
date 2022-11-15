<?php

namespace Flavorly\VanillaComponents\Core\Components;

class ToggleGroup extends BaseComponent
{
    use Concerns\HasOptions;

    protected string $component = 'VanillaToggleGroup';

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'options' => $this->getOptionsToArray(),
        ]);
    }
}
