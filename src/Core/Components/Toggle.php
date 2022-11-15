<?php

namespace Flavorly\VanillaComponents\Core\Components;

class Toggle extends BaseComponent
{
    use Concerns\HasCheckedAndUncheckedValue;
    use Concerns\CanBeAligned;

    protected string $component = 'VanillaToggle';

    public function __construct(string $name = null, string $label = null)
    {
        parent::__construct($name, $label);
        $this->toggle();
    }
}
