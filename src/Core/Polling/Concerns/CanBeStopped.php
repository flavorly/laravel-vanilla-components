<?php

namespace Flavorly\VanillaComponents\Core\Polling\Concerns;

use Closure;

trait CanBeStopped
{
    protected bool|Closure $stopWhenDataChanges = false;

    public function stopOnDataChange(bool|Closure $condition = true): static
    {
        $this->stopWhenDataChanges = $condition;

        return $this;
    }

    public function shouldStopWhenDateChanges(): bool
    {
        return $this->evaluate($this->stopWhenDataChanges);
    }
}
