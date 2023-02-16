<?php

namespace Flavorly\VanillaComponents\Datatables\Filters\Concerns;

use Closure;

trait HasFetchOptions
{
    protected string|Closure|null $fetchOptionsEndpoint = null;

    protected string|Closure|null $fetchOptionKey = null;

    protected string|Closure|null $fetchOptionLabel = null;

    public function fetchOptionsFrom(string|Closure|null $url, string|Closure $label, string|Closure|null $key = 'id'): static
    {
        $this->fetchOptionsEndpoint = $url;
        $this->fetchOptionKey = $key;
        $this->fetchOptionLabel = $label;

        return $this;
    }

    public function getFetchOptionKey(): ?string
    {
        return $this->evaluate($this->fetchOptionKey);
    }

    public function getFetchOptionLabel(): ?string
    {
        return $this->evaluate($this->fetchOptionLabel);
    }

    public function getFetchOptionsEndpoint(): ?string
    {
        return $this->evaluate($this->fetchOptionsEndpoint);
    }
}
