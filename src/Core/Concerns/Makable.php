<?php

namespace Flavorly\VanillaComponents\Core\Concerns;

trait Makable
{
    /**
     * Quick static constructor.
     */
    public static function make(array $args = []): static
    {
        return new static(...$args);
    }
}
