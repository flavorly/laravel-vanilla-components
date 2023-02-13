<?php

namespace Flavorly\VanillaComponents\Core\Concerns;

trait Makable
{
    /**
     * Quick static constructor.
     *
     * @param  array  $args
     * @return static
     */
    public static function make(array $args = []): static
    {
        return new static(...$args);
    }
}
