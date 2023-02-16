<?php

namespace Flavorly\VanillaComponents\Core\Concerns;

use Closure;

trait EvaluatesClosures
{
    /**
     * The identifier used to inject the component into the evaluation closure.
     */
    protected string $evaluationIdentifier;

    /**
     * The parameters that should be removed from the evaluation closure.
     */
    protected array $evaluationParametersToRemove = [];

    /**
     * Stolen from Filament, evaluate the closure with given params, and exclude some.
     *
     * @return mixed
     */
    protected function evaluate($value, array $parameters = [], array $exceptParameters = [])
    {
        $this->evaluationParametersToRemove = $exceptParameters;

        if ($value instanceof Closure) {
            return app()->call(
                $value,
                array_merge(
                    isset($this->evaluationIdentifier) ? [$this->evaluationIdentifier => $this] : [],
                    $this->getDefaultEvaluationParameters(),
                    $parameters,
                ),
            );
        }

        return $value;
    }

    /**
     * Get the default params that should be always injected
     */
    protected function getDefaultEvaluationParameters(): array
    {
        return [];
    }

    /**
     * Resolve the given evaluation parameter.
     *
     * @return mixed|null
     */
    protected function resolveEvaluationParameter(string $parameter, Closure $value)
    {
        if ($this->isEvaluationParameterRemoved($parameter)) {
            return null;
        }

        return $value();
    }

    /**
     * Determine if the given evaluation parameter should be removed.
     */
    protected function isEvaluationParameterRemoved(string $parameter): bool
    {
        return in_array($parameter, $this->evaluationParametersToRemove);
    }
}
