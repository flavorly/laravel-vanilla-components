<?php

namespace Flavorly\VanillaComponents\DataCasts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class ArrayToCollection implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        if (null === $value) {
            return collect();
        }

        return collect($value);
    }
}
