<?php

namespace Flavorly\VanillaComponents\Datatables\Options\General\Concerns;

use Closure;

trait CanManageSettings
{
    protected bool|Closure $isSettingsManaged = true;

    public function manageSettings(bool|Closure $condition = true): static
    {
        $this->isSettingsManaged = $condition;

        return $this;
    }

    public function isSettingsManageable(): bool
    {
        return $this->evaluate($this->isSettingsManaged);
    }
}
