<?php

namespace Flavorly\VanillaComponents\Datatables\Filters;

use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Core\Contracts as CoreContracts;
use Flavorly\VanillaComponents\Datatables\Concerns as BaseConcerns;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;

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
    use Macroable;

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
