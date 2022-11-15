<?php

namespace Flavorly\VanillaComponents\Datatables\Actions\Concerns;

use Illuminate\Support\Arr;
use Flavorly\VanillaComponents\Core\Confirmation\Confirmation;

trait CanBeConfirmed
{
    public function confirmation(Confirmation|null $confirmation = null): static
    {
        $this->before['confirm'] = $confirmation;

        return $this;
    }

    protected function getConfirmation(): Confirmation|null
    {
        return $this->evaluate(Arr::get($this->before, 'confirm'));
    }
}
