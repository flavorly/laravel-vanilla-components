<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

trait HasOriginUrl
{
    protected ?string $originUrl = null;

    public function originUrl(): ?string
    {
        return null;
    }

    public function setupOriginUrl(): void
    {
        $this->originUrl = $this->originUrl();
    }

    public function getOriginUrl(): ?string
    {
        return $this->originUrl;
    }
}
