<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use Flavorly\VanillaComponents\Datatables\Exceptions\DatatableMissingFetchEndpointException;

trait HasEndpoint
{
    protected ?string $fetchEndpoint = null;

    protected ?string $actionsEndpoint = null;

    public function fetchEndpoint(): ?string
    {
        return null;
    }

    public function actionsEndpoint(): ?string
    {
        return null;
    }

    public function setupEndpoints(): void
    {
        $fetchEndpoint = $this->fetchEndpoint();
        $actionsEndpoint = $this->fetchEndpoint();

        throw_if(empty($fetchEndpoint), new DatatableMissingFetchEndpointException());

        $this->fetchEndpoint = $fetchEndpoint;

        // If nothing was provided to actions, we can use the same endpoint as fetch
        // This probably the most wanted scenario.
        if ($actionsEndpoint === null) {
            $this->actionsEndpoint = $fetchEndpoint;
        }
    }

    public function getFetchEndpoint(): ?string
    {
        return $this->fetchEndpoint;
    }

    public function getActionsEndpoint(): ?string
    {
        return $this->actionsEndpoint;
    }
}
