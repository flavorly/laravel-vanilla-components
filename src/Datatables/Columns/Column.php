<?php

namespace VanillaComponents\Datatables\Columns;

use VanillaComponents\Core\Concerns as CoreConcerns;
use VanillaComponents\Core\Contracts as CoreContracts;
use VanillaComponents\Datatables\Concerns as BaseConcerns;

class Column implements CoreContracts\HasToArray
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use BaseConcerns\BelongsToTable;
    use Concerns\CanBeHidden;
    use Concerns\CanBeSortable;
    use Concerns\CanBeRaw;
    use Concerns\HasLabel;
    use Concerns\HasName;
    use Concerns\HasKey;

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'sortable' => $this->isSortable(),
            'native' => true, // TODO : check this
            'hidden' => $this->isHidden(),
            'raw' => $this->isRaw(),
        ];
    }
}
