<?php

namespace VanillaComponents\Core\Components;

class Select  extends BaseComponent
{
    use Concerns\HasOptions;

    protected string $component = 'VanillaSelect';

    public function toArray(): array
    {
        return array_merge(parent::toArray(),[
            'options' => $this->getOptionsToArray(),
        ]);
    }
}
