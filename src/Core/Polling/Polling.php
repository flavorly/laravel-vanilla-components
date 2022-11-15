<?php

namespace Flavorly\VanillaComponents\Core\Polling;

use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Core\Contracts as CoreContracts;
use Flavorly\VanillaComponents\Datatables\Concerns as BaseConcerns;
use Illuminate\Support\Traits\Macroable;

class Polling implements CoreContracts\HasToArray
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use BaseConcerns\BelongsToTable;
    use Concerns\CanBeToggled;
    use Concerns\CanBeStopped;
    use Concerns\HasInterval;
    use Macroable;

    public function toArray(): array
    {
        return [
            'enable' => $this->isEnabled(),
            'interval' => $this->getPoolEvery(),
            'during' => $this->getPoolDuring(),
            'stopWhenDataChanges' => $this->shouldStopWhenDateChanges(),
        ];
    }
}
