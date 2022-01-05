<?php

namespace Spatie\RouteDiscovery\PendingRoutes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionMethod;
use ReflectionParameter;
use Spatie\RouteDiscovery\Attributes\DiscoveryAttribute;
use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Attributes\Where;

class PendingRouteAction
{
    public ReflectionMethod $method;
    public string $uri;
    /** @var array<int, string> */
    public array $methods = [];

    /** @var array{class-string, string} */
    public array $action;

    /** @var array<int, class-string> */
    public array $middleware = [];

    /** @var array<string, string> */
    public array $wheres = [];
    public ?string $name = null;

    /**
     * @param ReflectionMethod $method
     * @param class-string $controllerClass
     */
    public function __construct(ReflectionMethod $method, string $controllerClass)
    {
        $this->method = $method;

        $this->uri = $this->relativeUri();

        $this->methods = $this->discoverHttpMethods();

        $this->action = [$controllerClass, $method->name];
    }

    public function relativeUri(): string
    {
        /** @var ReflectionParameter $modelParameter */
        $modelParameter = collect($this->method->getParameters())->first(function (ReflectionParameter $parameter) {
            /** @phpstan-ignore-next-line */
            return is_a($parameter->getType()?->getName(), Model::class, true);
        });

        $uri = '';

        if (! in_array($this->method->getName(), $this->commonControllerMethodNames())) {
            $uri = Str::kebab($this->method->getName());
        }

        /** @phpstan-ignore-next-line */
        if ($modelParameter) {
            if ($uri !== '') {
                $uri .= '/';
            }

            $uri .= "{{$modelParameter->getName()}}";
        }

        return $uri;
    }

    public function addWhere(Where $whereAttribute): self
    {
        $this->wheres[$whereAttribute->param] = $whereAttribute->constraint;

        return $this;
    }

    /**
     * @param array<class-string>|class-string $middleware
     *
     * @return self
     */
    public function addMiddleware(array|string $middleware): self
    {
        $middleware = Arr::wrap($middleware);

        $allMiddleware = array_merge($middleware, $this->middleware);

        $this->middleware = array_unique($allMiddleware);

        return $this;
    }

    /**
     * @return array<int, string>
     */
    protected function discoverHttpMethods(): array
    {
        return match ($this->method->name) {
            'index', 'create', 'show', 'edit' => ['GET'],
            'store' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'destroy', 'delete' => ['DELETE'],
            default => ['GET'],
        };
    }

    /** @return array<int, string> */
    protected function commonControllerMethodNames(): array
    {
        return [
            'index', '__invoke', 'get',
            'show', 'store', 'update',
            'destroy', 'delete',
        ];
    }

    public function getRouteAttribute(): ?Route
    {
        return $this->getAttribute(Route::class);
    }

    /**
     * @template TDiscoveryAttribute of DiscoveryAttribute
     *
     * @param class-string<TDiscoveryAttribute> $attributeClass
     *
     * @return ?TDiscoveryAttribute
     */
    public function getAttribute(string $attributeClass): ?DiscoveryAttribute
    {
        $attributes = $this->method->getAttributes($attributeClass, ReflectionAttribute::IS_INSTANCEOF);

        if (! count($attributes)) {
            return null;
        }

        return $attributes[0]->newInstance();
    }
}
