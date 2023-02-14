<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Flavorly\VanillaComponents\Core\Integrations\VanillaInertia;

trait HasInertiaAction
{
    protected ?VanillaInertia $inertia = null;

    public function inertia(Closure|VanillaInertia $inertia): static
    {
        $this->inertia = $this->inertia ?? new VanillaInertia();
        $this->evaluate($inertia, ['inertia' => $this->inertia]);

        return $this;
    }

    protected function getInertia(): ?VanillaInertia
    {
        return $this?->inertia;
    }
}
