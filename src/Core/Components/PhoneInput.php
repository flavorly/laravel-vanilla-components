<?php

namespace VanillaComponents\Core\Components;

use VanillaComponents\Core\Components\Concerns;

class PhoneInput  extends BaseComponent
{
    use Concerns\CanBeSearchable;

    protected string $component = 'VanillaPhoneInput';
}
