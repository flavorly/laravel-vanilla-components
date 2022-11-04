<?php

namespace VanillaComponents\Core\Polling;

use VanillaComponents\Core\Contracts as CoreContracts;
use VanillaComponents\Datatables\Concerns as BaseConcerns;
use VanillaComponents\Core\Polling\Concerns;
use VanillaComponents\Core\Concerns as CoreConcerns;

class PollingOptions implements CoreContracts\HasToArray
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
            'stopWhenDataChanges' => $this->shouldStopWhenDateChanges()
        ];
    }
}