<?php

namespace VanillaComponents\Core\Components;

use VanillaComponents\Core\Concerns as CoreConcerns;
use VanillaComponents\Core\Contracts as CoreContracts;

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
