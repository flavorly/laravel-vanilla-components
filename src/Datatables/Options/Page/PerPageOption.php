<?php

namespace VanillaComponents\Datatables\Options\Page;

use Illuminate\Support\Traits\Macroable;
use VanillaComponents\Core\Concerns as CoreConcerns;
use VanillaComponents\Core\Contracts as CoreContracts;
use VanillaComponents\Datatables\Concerns as BaseConcerns;

class PerPageOption implements CoreContracts\HasToArray
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use BaseConcerns\BelongsToTable;
    use Concerns\HasLabelAndValue;
    use Concerns\CanBeDefault;
    use Macroable;

    public function toArray(): array
    {
        return [
            'value' => $this->getValue(),
            'text' => $this->getLabel(),
            'default' => $this->isDefault(),
        ];
    }
}
