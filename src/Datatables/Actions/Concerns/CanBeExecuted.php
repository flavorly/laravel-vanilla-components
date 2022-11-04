<?php

namespace VanillaComponents\Datatables\Actions\Concerns;

use Closure;
use Illuminate\Support\Collection;

trait CanBeExecuted
{
    protected null | Closure | string $executeUsing = null;

    public function executeUsing(Closure|null|string $closureOrInvokable = null): static
    {
        $this->executeUsing = $closureOrInvokable;
        return $this;
    }

    public function getExecuteUsing(): null | Closure | string
    {
        return $this->executeUsing;
    }

    public function execute(Collection|null|array $ids = null): void
    {
        if($this->executeUsing === null){
            return;
        }

        if($this->getExecuteUsing() instanceof Closure) {
            app()->call($this->getExecuteUsing(), [
                'action' => $this,
                'ids' => $ids,
            ]);
        }

        if(is_string($this->getExecuteUsing())) {
            app()->call($this->getExecuteUsing(), [
                'action' => $this,
                'ids' => $ids,
            ]);
        }
    }
}
