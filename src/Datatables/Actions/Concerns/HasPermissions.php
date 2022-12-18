<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;

trait HasPermissions
{
    protected bool|Closure $canSee = true;

    protected bool|Closure $canExecute = true;

    public function canSee(bool|Closure $boolean = true): static
    {
        $this->canSee = $boolean;

        return $this;
    }

    public function canExecute(bool|Closure $boolean = true): static
    {
        $this->canExecute = $boolean;

        return $this;
    }

    protected function getCanSee(): bool
    {
        return $this->evaluate($this->canSee);
    }

    protected function getCanExecute(): bool
    {
        return $this->evaluate($this->canExecute);
    }

    protected function getPermissionsToArray(): array
    {
        return [
            'view' => $this->getCanSee(),
            'execute' => $this->getCanExecute(),
        ];
    }
}
