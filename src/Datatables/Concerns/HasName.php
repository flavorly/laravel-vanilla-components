<?php

namespace Flavorly\VanillaComponents\Datatables\Concerns;

trait HasName
{
    protected ?string $name = null;

    public function name(): string
    {
        return md5(static::class);
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
