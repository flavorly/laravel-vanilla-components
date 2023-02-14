<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

use ReflectionClass;

trait HasName
{
    protected ?string $name = null;

    public function name(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function setupName(): void
    {
        $this->name = $this->name();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
