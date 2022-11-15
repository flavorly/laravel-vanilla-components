<?php

namespace Flavorly\VanillaComponents\Datatables\PendingAction;

use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Datatables\PendingAction\Concerns;

class PendingAction
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use Concerns\HasCollectionOfRows;
    use Concerns\CanAllBeSelected;
    use Concerns\BelongsToAction;
    use Concerns\HasQueryBuilder;
}
