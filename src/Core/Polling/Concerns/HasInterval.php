<?php

namespace Flavorly\VanillaComponents\Core\Polling\Concerns;

use PhpParser\Node\Expr\Closure;

trait HasInterval
{
    protected int|float $poolEvery = 5;

    protected int|float $poolDuring = 120;

    public function every(int|float|Closure $secondsOrClosure = 5): static
    {
        $this->poolEvery = $secondsOrClosure;

        return $this;
    }

    public function during(int|float|Closure $secondsOrClosure = 120): static
    {
        $this->poolDuring = $secondsOrClosure;

        return $this;
    }

    public function getPoolEvery(): int|float
    {
        return $this->evaluate($this->poolEvery);
    }

    public function getPoolDuring(): int|float
    {
        return $this->evaluate($this->poolDuring);
    }
}
