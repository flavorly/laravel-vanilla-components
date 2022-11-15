<?php

namespace Flavorly\VanillaComponents\Datatables\Options\Page;

use Illuminate\Support\Traits\Macroable;
use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Core\Contracts as CoreContracts;
use Flavorly\VanillaComponents\Datatables\Concerns as BaseConcerns;

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
