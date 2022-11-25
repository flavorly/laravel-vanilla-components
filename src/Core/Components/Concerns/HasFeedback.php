<?php

namespace Flavorly\VanillaComponents\Core\Components\Concerns;

use Closure;

trait HasFeedback
{
    protected string | Closure | null $feedback = null;

    public function feedback(string | Closure | null $feedback): static
    {
        $this->feedback = $feedback;

        return $this;
    }

    public function getFeedback(): ?string
    {
        return $this->evaluate($this->feedback);
    }
}
