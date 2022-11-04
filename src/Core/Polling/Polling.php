<?php

namespace VanillaComponents\Core\Polling;

use VanillaComponents\Core\Concerns as CoreConcerns;
use VanillaComponents\Core\Contracts as CoreContracts;
use VanillaComponents\Datatables\Concerns as BaseConcerns;

class Polling implements CoreContracts\HasToArray
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use BaseConcerns\BelongsToTable;
    use Concerns\CanBeToggled;
    use Concerns\CanBeStopped;
    use Concerns\HasInterval;

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
