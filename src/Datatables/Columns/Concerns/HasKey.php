<?php

namespace VanillaComponents\Datatables\Columns\Concerns;

trait HasKey
{
    protected string $key;

    public function key(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
