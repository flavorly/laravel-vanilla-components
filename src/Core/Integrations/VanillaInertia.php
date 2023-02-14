<?php

namespace Flavorly\VanillaComponents\Core\Integrations;

use Closure;
use Flavorly\VanillaComponents\Core\Concerns\EvaluatesClosures;
use Illuminate\Support\Arr;

class VanillaInertia
{
    use EvaluatesClosures;

    public function __construct(
        protected bool $reload = false,
        protected ?string $url = null,
        protected array $query = [],
        protected array $options = [],
    ){}

    public function reload(bool|Closure $reload = true): static
    {
        $this->reload = $this->evaluate($reload);

        return $this;
    }

    public function visit(string|Closure $url): static
    {
        $this->url = $this->evaluate($url);
        $this->reload = false;

        return $this;
    }

    public function route(string|Closure $name): static
    {
        return $this->visit(route($this->evaluate($name)));
    }

    public function preserve(bool|Closure $state = true, bool|Closure $scroll = true): static
    {
        $this->options['preserveState'] = $this->evaluate($state);
        $this->options['preserveScroll'] = $this->evaluate($scroll);

        return $this;
    }

    public function replace(bool|Closure $replace = true): static
    {
        $this->options['replace'] = $this->evaluate($replace);
        return $this;
    }

    public function method(string|Closure $method = 'POST'): static
    {
        $this->options['method'] = $this->evaluate($method);
        return $this;
    }

    public function post(array|Closure $data = []): static
    {
        $data = $this->evaluate($data);
        if(!empty($data)){
            $this->data($data);
        }
        return $this->method();
    }

    public function get(): static
    {
        return $this->method('GET');
    }

    public function put(): static
    {
        return $this->method('PUT');
    }

    public function patch(): static
    {
        return $this->method('PATCH');
    }

    public function delete(): static
    {
        return $this->method('DELETE');
    }

    public function only(array|Closure $keys): static
    {
        $this->options['only'] = array_unique(
            array_merge(
                Arr::get($this->options, 'only', []),
                $this->evaluate($keys)
            )
        );
        return $this;
    }

    public function headers(array|Closure $headers): static
    {
        $this->options['headers'] = array_unique(
            array_merge(
                Arr::get($this->options, 'headers', []),
                $this->evaluate($headers)
            )
        );
        return $this;
    }

    public function data(array|Closure $data = []): static
    {
        $this->options['data'] = array_merge_recursive(
            Arr::get($this->options, 'data', []),
            $this->evaluate($data)
        );
        return $this;
    }

    public function query(array|Closure $params = []): self
    {
        $this->query = array_unique(
            array_merge(
                $this->query,
                $params
            )
        );
        return $this;
    }

    public function options(array|Closure $options = []): static
    {
        $this->options = array_unique(
            array_merge(
                $this->options,
                $this->evaluate($options)
            )
        );
        return $this;
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'reload' => $this->reload,
            'query' => $this->query,
            'options' => array_filter(array_merge([
                'method' => 'GET',
                'preserveState' => true,
                'preserveScroll' => true,
            ],$this->options)),
        ];
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
}
