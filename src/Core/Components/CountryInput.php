<?php

namespace Flavorly\VanillaComponents\Core\Components;

class CountryInput extends BaseComponent
{
    use Concerns\CanBeSearchable;
    use Concerns\HasFavoriteCountries;

    protected string $component = 'VanillaInput';
}
