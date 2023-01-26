<?php

namespace Flavorly\VanillaComponents\Datatables\Options\General;

use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Core\Contracts as CoreContracts;
use Flavorly\VanillaComponents\Datatables\Concerns as BaseConcerns;
use Illuminate\Support\Traits\Macroable;

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
    use Macroable;

    public function toArray(): array
    {
        return [
            'selectable' => $this->isSelectable(),
            'allSelectable' => $this->isAllSelectable(),
            'searchable' => $this->isSearchable(),
            'isSearchHidden' => $this->isSearchBarHiddenByDefault(),
            'refreshable' => $this->isRefreshable(),
            'manageSettings' => $this->isSettingsManageable(),
            'showTotalItems' => $this->isTotalNumberOfItemsVisible(),
            'showPages' => $this->isShowingPages(),
            'compact' => $this->isCompact(),
            'striped' => $this->isStriped(),
        ];
    }
}
