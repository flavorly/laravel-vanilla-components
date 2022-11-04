<?php

namespace VanillaComponents\Core\Components;

class RichSelect extends BaseComponent
{
    use Concerns\CanBeSearchable;
    use Concerns\HasOptions;

    protected string $component = 'VanillaRichSelect';

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'options' => $this->getOptionsToArray(),
        ]);
    }
}
