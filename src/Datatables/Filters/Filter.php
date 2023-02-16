<?php

namespace Flavorly\VanillaComponents\Datatables\Filters;

use Flavorly\VanillaComponents\Core\Components\BaseComponent;
use Flavorly\VanillaComponents\Core\Components\Concerns\HasFetchOptions;
use Flavorly\VanillaComponents\Core\Components\Concerns\HasMultipleValues;
use Flavorly\VanillaComponents\Core\Components\Concerns\HasOptions;
use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Core\Contracts as CoreContracts;
use Flavorly\VanillaComponents\Datatables\Concerns as BaseConcerns;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;

class Filter implements CoreContracts\HasToArray
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use BaseConcerns\BelongsToTable;
    use Concerns\HasName;
    use Concerns\HasLabel;
    use Concerns\HasOptions;
    use Concerns\HasHTMLAttributes;
    use Concerns\HasValueAndDefaultValue;
    use Concerns\HasComponentTypes;
    use Concerns\InteractsWithTableQuery;
    use Concerns\HasPlaceholder;
    use Concerns\HasErrors;
    use Concerns\HasFeedback;
    use Concerns\HasFetchOptions;
    use Concerns\HasMultipleValues;
    use Macroable;

    public static function fromComponent(BaseComponent $baseComponent): static
    {
        $static = new static();
        $static
            ->name($baseComponent->getName())
            ->label($baseComponent->getLabel())
            ->component($baseComponent->getComponent())
            ->placeholder($baseComponent->getPlaceholder())
            ->attributes($baseComponent->getAttributes())
            ->value($baseComponent->getValue())
            ->feedback($baseComponent->getFeedback())
            ->errors($baseComponent->getErrors())
            ->defaultValue($baseComponent->getDefaultValue());

        if (in_array(HasMultipleValues::class, class_uses($baseComponent::class))) {
            /** @var HasMultipleValues|BaseComponent $baseComponent */
            $static->multiple($baseComponent->getIsMultiple());
        }

        if (in_array(HasOptions::class, class_uses($baseComponent::class))) {
            /** @var HasOptions|BaseComponent $baseComponent */
            $static->options($baseComponent->getOptions());
        }

        if (in_array(HasFetchOptions::class, class_uses($baseComponent::class))) {
            /** @var HasFetchOptions|BaseComponent $baseComponent */
            if ($baseComponent->getFetchOptionsEndpoint() !== null) {
                $static->fetchOptionsFrom(
                    $baseComponent->getFetchOptionsEndpoint(),
                    $baseComponent->getFetchOptionLabel(),
                    $baseComponent->getFetchOptionKey()
                );
            }
        }

        return $static;
    }

    public function toArray(): array
    {
        $hasFetchOptions = $this->getFetchOptionsEndpoint() !== null;

        return array_merge(
            [
                'name' => $this->getName(),
                'label' => $this->getLabel(),
                'component' => $this->getComponent(),
                'placeholder' => $this->getPlaceholder() ?? Arr::get($this->getAttributes(), 'placeholder'),
                'attributes' => $this->getAttributes(),
                'value' => $this->getValue(),
                'defaultValue' => $this->getDefaultValue(),
                'feedback' => $this->getFeedback(),
                'errors' => $this->getErrors(),
                'options' => $this->getOptionsToArray(),
                'multiple' => $this->getIsMultiple(),
            ],
            $hasFetchOptions ? [
                'fetchEndpoint' => $this->getFetchOptionsEndpoint(),
                'valueAttribute' => $this->getFetchOptionKey(),
                'textAttribute' => $this->getFetchOptionLabel(),
            ] : []
        );
    }
}
