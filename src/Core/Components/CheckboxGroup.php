<?php

namespace VanillaComponents\Core\Components;

use VanillaComponents\Core\Components\Concerns;
class CheckboxGroup extends BaseComponent
{
    use Concerns\HasOptions;

    protected string $component = 'VanillaCheckboxGroup';

    public function toArray(): array
    {
        return array_merge(parent::toArray(),[
            'options' => $this->getOptionsToArray(),
        ]);
    }
}