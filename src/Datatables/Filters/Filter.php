<?php

namespace VanillaComponents\Datatables\Filters;

use Illuminate\Support\Arr;
use VanillaComponents\Datatables\Concerns as BaseConcerns;
use VanillaComponents\Core\Contracts as CoreContracts;
use VanillaComponents\Core\Concerns as CoreConcerns;
use VanillaComponents\Datatables\Filters\Concerns;


class Filter implements CoreContracts\HasToArray
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use BaseConcerns\BelongsToTable;
    use Concerns\HasName;
    use Concerns\HasLabel;
    use Concerns\HasOptions;
    use Concerns\HasHTMLAttributes;
    use Concerns\HasValueAndDefaultValue;
    use Concerns\HasComponentTypes;
    use Concerns\InteractsWithTableQuery;

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'component' => $this->getComponent(),
            'placeholder' => Arr::get($this->getAttributes(), 'placeholder'),
            'attributes' => $this->getAttributes(),
            'value' => $this->getValue(),
            'defaultValue' => $this->getDefaultValue(),
            'options' => $this->getOptionsToArray(),
        ];
    }
}
