<?php

namespace VanillaComponents\Core\Components;

use VanillaComponents\Core\Components\Concerns;

class CountryInput  extends BaseComponent
{
    use Concerns\CanBeSearchable;
    use Concerns\HasFavoriteCountries;

    protected string $component = 'VanillaInput';
}
