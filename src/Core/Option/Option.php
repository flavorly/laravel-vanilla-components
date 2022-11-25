<?php

namespace Flavorly\VanillaComponents\Core\Option;

use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Core\Contracts\HasToArray;
use Flavorly\VanillaComponents\Core\Option\Concerns as BaseConcerns;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

class Option implements HasToArray
{
    use BaseConcerns\CanBeDisabled;
    use BaseConcerns\HasLabelAndValue;
    use BaseConcerns\HasChildren;
    use CoreConcerns\Makable;
    use CoreConcerns\EvaluatesClosures;
    use Macroable;

    public function fromArray(array|Collection $array): array
    {
        if (is_array($array)) {
            $array = collect($array);
        }

        return $array
            ->map(fn ($option) => $this->fromArrayToOption($option))
            ->toArray();
    }

    protected function fromArrayToOption(array|Collection|Option $array)
    {
        if (is_array($array)) {
            $array = collect($array);
        }

        if ($array instanceof Option) {
            $array = $array->toArray();
        }

        if ($array instanceof Option) {
            return $array;
        }

        return Option::make()
            ->value(Arr::get($array, $this->valueKey, Arr::get($array, 'val')))
            ->label(Arr::get($array, $this->labelKey, Arr::get($array, 'label')))
            ->children(Arr::get($array, $this->childrenKey, Arr::get($array, 'options')))
            ->disabled((bool) Arr::get($array, $this->disabledKey, Arr::get($array, 'disable', false)));
    }

    public function toArray(): array
    {
        return collect([
            $this->labelKey => $this->getLabel(),
            $this->valueKey => $this->getValue(),
            $this->disabledKey => $this->isDisabled(),
            $this->childrenKey => $this->getChildrenToArray(),
        ])
        ->filter(function ($value, $key) {
            if ($key === $this->childrenKey) {
                return ! empty($value);
            }
            if ($key === $this->disabledKey && $value === false) {
                return false;
            }

            return true;
        })
        ->toArray();
    }
}
