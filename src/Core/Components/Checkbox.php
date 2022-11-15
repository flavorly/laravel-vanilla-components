<?php

namespace Flavorly\VanillaComponents\Core\Components;

class Checkbox extends BaseComponent
{
    use Concerns\HasCheckedAndUncheckedValue;
    use Concerns\CanBeAligned;

    protected string $component = 'VanillaCheckbox';
}
