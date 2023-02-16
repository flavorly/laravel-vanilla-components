<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Closure;

trait HasRedirect
{
    protected ?string $redirectTo = null;

    protected bool $redirectToNewTab = false;

    public function redirect(Closure|string $url, Closure|bool $openInNewTab = false): static
    {
        $this->redirectTo = $this->evaluate($url);
        $this->redirectToNewTab = $this->evaluate($openInNewTab);

        return $this;
    }

    public function redirectToRoute(Closure|string $route, Closure|bool $openInNewTab = false): static
    {
        $this->redirect(route($this->evaluate($route)), $openInNewTab);

        return $this;
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->redirectTo;
    }

    protected function shouldRedirectToNewTab(): bool
    {
        return $this->redirectToNewTab;
    }
}
