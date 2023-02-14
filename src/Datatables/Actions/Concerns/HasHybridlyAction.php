<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Flavorly\VanillaComponents\Core\Integrations\VanillaHybridly;

trait HasHybridlyAction
{
    protected ?VanillaHybridly $hybridly = null;

    public function hybridly(Closure|VanillaHybridly $hybridly): static
    {
        $this->hybridly = $this->hybridly ?? new VanillaHybridly();
        $this->evaluate($hybridly, ['hybridly' => $this->hybridly]);

        return $this;
    }

    protected function getHybridly(): ?VanillaHybridly
    {
        return $this?->hybridly;
    }
}
