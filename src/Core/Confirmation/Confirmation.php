<?php

namespace Flavorly\VanillaComponents\Core\Confirmation;

use Flavorly\VanillaComponents\Core\Concerns as CoreConcerns;
use Flavorly\VanillaComponents\Core\Contracts as CoreContracts;
use Illuminate\Support\Traits\Macroable;

class Confirmation implements CoreContracts\HasToArray
{
    use CoreConcerns\EvaluatesClosures;
    use CoreConcerns\Makable;
    use Concerns\HasTitle;
    use Concerns\HasSubtitle;
    use Concerns\HasText;
    use Concerns\HasClasses;
    use Concerns\HasButtons;
    use Concerns\HasComponent;
    use Concerns\HasLevel;
    use Concerns\CanBeRaw;
    use Concerns\CanBeEnabledOrDisabled;
    use Macroable;

    public function toArray(): array
    {
        return [
            'enable' => $this->isEnabled(),
            'title' => $this->getTitle(),
            'subtitle' => $this->getSubtitle(),
            'text' => $this->getText(),
            'confirmButton' => $this->getConfirmationButtonText(),
            'cancelButton' => $this->getCancelButtonText(),
            'safe' => $this->isRaw(),
            'level' => $this->getLevel(),
            'classes' => $this->getClasses(),
        ];
    }
}
