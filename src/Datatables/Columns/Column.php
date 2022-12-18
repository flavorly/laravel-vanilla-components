<?php

namespace Flavorly\VanillaComponents\Datatables\Columns;

use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Core\Contracts as CoreContracts;
use Flavorly\VanillaComponents\Datatables\Concerns as BaseConcerns;
use Illuminate\Support\Traits\Macroable;

class Column implements CoreContracts\HasToArray
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use BaseConcerns\BelongsToTable;
    use Concerns\CanBeHidden;
    use Concerns\CanBeSortable;
    use Concerns\CanBeRaw;
    use Concerns\CanBeSelected;
    use Concerns\HasLabel;
    use Concerns\HasName;
    use Concerns\HasKey;
    use Macroable;

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'sortable' => $this->isSortable(),
            'sorting' => $this->getSortDirection(),
            'native' => true,
            'hidden' => $this->isHidden(),
            'raw' => $this->isRaw(),
        ];
    }
}
