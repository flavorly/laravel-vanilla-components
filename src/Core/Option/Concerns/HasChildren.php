<?php

namespace VanillaComponents\Core\Option\Concerns;

use Closure;

trait HasChildren
{
    protected string $childrenKey = 'children';

    protected array | Closure $children = [];

    public function children(array | Closure | null $options): static
    {
        $options = $this->evaluate($options);
        if (! is_array($options)) {
            return $this;
        }

        $this->children = collect($options)
            ->map(fn ($option) => self::fromArrayToOption($option))
            ->toArray();

        return $this;
    }

    public function getChildren(): array
    {
        return $this->evaluate($this->children);
    }

    public function getChildrenToArray(): array
    {
        return collect($this->getChildren())->map(fn ($option) => $option->toArray())->toArray();
    }

    public function hasChildren(): bool
    {
        return ! empty($this->evaluate($this->children));
    }
}
