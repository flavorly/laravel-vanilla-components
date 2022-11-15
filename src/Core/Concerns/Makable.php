<?php

namespace Flavorly\VanillaComponents\Core\Concerns;

trait Makable
{
    public static function make(array $args = []): static
    {
        return new static(...$args);
    }
}
