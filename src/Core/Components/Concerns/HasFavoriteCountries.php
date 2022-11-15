<?php

namespace Flavorly\VanillaComponents\Core\Components\Concerns;

use Closure;

trait HasFavoriteCountries
{
    protected array | Closure $favoriteCountries = ['US', 'GB', 'PT', 'FR', 'DE'];

    public function favoriteCountries(array | Closure $countries = ['US', 'GB', 'PT', 'FR', 'DE']): static
    {
        $this->favoriteCountries = $countries;

        return $this;
    }

    public function getFavoriteCountries(): string
    {
        return $this->evaluate($this->favoriteCountries);
    }
}
