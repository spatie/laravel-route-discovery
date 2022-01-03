<?php

namespace Spatie\RouteDiscovery\Attributes;

use Attribute;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;

#[Attribute(Attribute::TARGET_METHOD)]
class Route implements RouteAttribute
{
    public array $methods;

    public array $middleware;

    public function __construct(
        array | string $method = [],
        public ?string $uri = null,
        public ?string $name = null,
        array | string $middleware = [],
    ) {
        $methods = Arr::wrap($method);

        $this->methods = collect($methods)
            ->map(fn (string $method) => strtoupper($method))
            ->filter(fn (string $method) => in_array($method, Router::$verbs))
            ->toArray();

        $this->middleware = Arr::wrap($middleware);
    }

    public static function new(): self
    {
        return new self;
    }
}
