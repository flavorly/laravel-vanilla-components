<?php

namespace VanillaComponents\Core\Components;

use VanillaComponents\Core\Components\Concerns;;

class Checkbox extends BaseComponent
{
    use Concerns\HasCheckedAndUncheckedValue;
    use Concerns\CanBeAligned;

    protected string $component = 'VanillaCheckbox';
}
