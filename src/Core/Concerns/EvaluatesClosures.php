<?php

namespace Flavorly\VanillaComponents\Core\Concerns;

use Closure;

trait EvaluatesClosures
{
    /**
     * The identifier used to inject the component into the evaluation closure.
     *
     * @var string
     */
    protected string $evaluationIdentifier;

    /**
     * The parameters that should be removed from the evaluation closure.
     *
     * @var array
     */
    protected array $evaluationParametersToRemove = [];

    /**
     * Stolen from Filament, evaluate the closure with given params, and exclude some.
     *
     * @param $value
     * @param  array  $parameters
     * @param  array  $exceptParameters
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
     *
     * @return array
     */
    protected function getDefaultEvaluationParameters(): array
    {
        return [];
    }

    /**
     * Resolve the given evaluation parameter.
     *
     * @param  string  $parameter
     * @param  Closure  $value
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
     *
     * @param  string  $parameter
     * @return bool
     */
    protected function isEvaluationParameterRemoved(string $parameter): bool
    {
        return in_array($parameter, $this->evaluationParametersToRemove);
    }
}
