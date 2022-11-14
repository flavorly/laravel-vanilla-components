<?php

namespace VanillaComponents\Datatables\PendingAction;

use VanillaComponents\Core\Concerns as CoreConcerns;

class PendingAction
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use Concerns\HasCollectionOfRows;
    use Concerns\CanAllBeSelected;
    use Concerns\BelongsToAction;
}
