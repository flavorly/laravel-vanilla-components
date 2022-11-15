<?php

namespace Flavorly\VanillaComponents\Core\Components;

use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Core\Contracts as CoreContracts;
use Illuminate\Support\Traits\Macroable;

abstract class BaseComponent implements CoreContracts\HasToArray
{
    use Concerns\HasHTMLAttributes;
    use Concerns\HasLabel;
    use Concerns\HasName;
    use Concerns\HasValueAndDefaultValue;
    use Concerns\HasComponentTypes;
    use Concerns\HasPlaceholder;
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use Macroable;

    public function __construct(string $name = null, string $label = null)
    {
        $this->name($name);
        $this->label($label);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'component' => $this->getComponent(),
            'placeholder' => $this->getPlaceholder(),
            'attributes' => $this->getAttributes(),
            'value' => $this->getValue(),
            'defaultValue' => $this->getDefaultValue(),
        ];
    }
}
