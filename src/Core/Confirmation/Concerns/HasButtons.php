<?php

namespace Flavorly\VanillaComponents\Core\Confirmation\Concerns;

use Closure;

trait HasButtons
{
    protected null | string | Closure $confirmButtonLabel = 'Ok, got it';

    protected null | string | Closure $cancelButtonLabel = 'Nah, cancel';

    public function buttons(string|null|Closure $confirmButtonText = 'Ok, got it', string|null|Closure $cancelButtonText = 'Nah, cancel'): static
    {
        $this->confirmButtonLabel = $confirmButtonText;
        $this->cancelButtonLabel = $cancelButtonText;

        return $this;
    }

    public function confirmationButtonText(string|null|Closure $confirmButtonText = null): static
    {
        $this->confirmButtonLabel = $confirmButtonText;

        return $this;
    }

    public function cancelButtonText(string|null|Closure $cancelButtonText = null): static
    {
        $this->cancelButtonLabel = $cancelButtonText;

        return $this;
    }

    public function getConfirmationButtonText(): string|null
    {
        return $this->evaluate($this->confirmButtonLabel);
    }

    public function getCancelButtonText(): string|null
    {
        return $this->evaluate($this->cancelButtonLabel);
    }
}
