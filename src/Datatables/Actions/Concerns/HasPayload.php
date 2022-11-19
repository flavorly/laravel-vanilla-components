<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Flavorly\VanillaComponents\Datatables\Http\Payload\RequestPayload;

trait HasPayload
{
    protected ?RequestPayload $payload = null;

    public function withData(?RequestPayload $payload = null): static
    {
        $this->payload = $payload;

        return $this;
    }

    protected function getData(): ?RequestPayload
    {
        return $this->evaluate($this->payload);
    }
}
