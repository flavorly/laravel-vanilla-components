<?php

namespace VanillaComponents\Core\Polling\Concerns;

trait HasInterval
{
    protected int|float $poolEvery = 5;

    protected int|float $poolDuring = 120;

    public function every(bool | array $secondsOrClosure = true): static
    {
        $this->poolEvery = $secondsOrClosure;

        return $this;
    }

    public function during(bool | array $secondsOrClosure = true): static
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
