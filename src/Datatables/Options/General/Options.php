<?php

namespace VanillaComponents\Datatables\Options\General;

use VanillaComponents\Core\Contracts as CoreContracts;
use VanillaComponents\Datatables\Concerns as BaseConcerns;
use VanillaComponents\Datatables\Options\General\Concerns;
use VanillaComponents\Core\Concerns as CoreConcerns;

class Options implements CoreContracts\HasToArray
{
    use BaseConcerns\BelongsToTable;
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use Concerns\CanBeSelectable;
    use Concerns\CanBeSearchable;
    use Concerns\CanBeRefreshable;
    use Concerns\CanManageSettings;
    use Concerns\CanShowDetailedPagination;
    use Concerns\CanBeCompact;
    use Concerns\CanBeStriped;

    public function toArray(): array
    {
        return [
            'selectable' => $this->isSelectable(),
            'searchable' => $this->isSearchable(),
            'refreshable' => $this->isRefreshable(),
            'manageSettings' => $this->isSettingsManageable(),
            'showTotalItems' => $this->isTotalNumberOfItemsVisible(),
            'compact' => $this->isCompact(),
            'striped' => $this->isStriped(),
        ];
    }
}
