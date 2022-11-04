<?php

namespace VanillaComponents\Core\Confirmation;

use VanillaComponents\Core\Concerns as CoreConcerns;
use VanillaComponents\Core\Contracts as CoreContracts;

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
