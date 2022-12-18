<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;

trait HasHooks
{
    protected null|Closure $onBefore = null;

    protected null|Closure $onAfter = null;

    protected null|Closure $onFinished = null;

    protected null|Closure $onFailed = null;

    public function onBefore(Closure|null $closure = null): static
    {
        $this->onBefore = $closure;

        return $this;
    }

    public function onAfter(Closure|null $closure = null): static
    {
        $this->onAfter = $closure;

        return $this;
    }

    public function onFinished(Closure|null $closure = null): static
    {
        $this->onFinished = $closure;

        return $this;
    }

    public function onFailed(Closure|null $closure = null): static
    {
        $this->onFailed = $closure;

        return $this;
    }
}
