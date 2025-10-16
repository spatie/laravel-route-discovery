<?php

namespace Spatie\RouteDiscovery\PendingRoutes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionMethod;
use ReflectionNamedType;
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

    /** @var Collection<int, ReflectionParameter> */
    public Collection $modelParameters;

    /** @var array{class-string, string} */
    public array $action;

    /** @var array<int, class-string|string> */
    public array $middleware = [];

    /** @var array<string, string> */
    public array $wheres = [];
    public ?string $name = null;

    public ?string $domain = null;

    public bool $withTrashed = false;

    /**
     * @param ReflectionMethod $method
     * @param class-string $controllerClass
     */
    public function __construct(ReflectionMethod $method, string $controllerClass)
    {
        $this->method = $method;

        $this->modelParameters = $this->modelParameters();

        $this->uri = $this->relativeUri();

        $this->methods = $this->discoverHttpMethods();

        $this->action = [$controllerClass, $method->name];
    }

    /**
     * @return Collection<int, ReflectionParameter>
     */
    public function modelParameters(): Collection
    {
        return collect($this->method->getParameters())->filter(function (ReflectionParameter $parameter) {
            $type = $parameter->getType();

            return $type instanceof ReflectionNamedType && is_a($type->getName(), Model::class, true);
        });
    }

    public function relativeUri(): string
    {
        $uri = '';

        if (! in_array($this->method->getName(), $this->commonControllerMethodNames())) {
            $uri = Str::kebab($this->method->getName());
        }

        if ($this->modelParameters->isNotEmpty()) {
            if ($uri !== '') {
                $uri .= '/';
            }
            $uri .= $this->modelParameters
                ->map(fn (ReflectionParameter $parameter) => $this->formatParameterForUri($parameter))
                ->implode('/');
        }

        return $uri;
    }

    public function addWhere(Where $whereAttribute): self
    {
        $this->wheres[$whereAttribute->param] = $whereAttribute->constraint;

        return $this;
    }

    /**
     * @param array<class-string|string>|class-string|string $middleware
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

    /**
     * @return array<int, string>
     */
    protected function commonControllerMethodNames(): array
    {
        return [
            'index', '__invoke', 'get',
            'show', 'store', 'update',
            'destroy', 'delete',
        ];
    }

    /**
     * @return string|array{string, string}
     */
    public function action(): string|array
    {
        return $this->action[1] === '__invoke'
            ? $this->action[0]
            : $this->action;
    }

    public function getRouteAttribute(): ?DiscoveryAttribute
    {
        return $this->getAttribute(Route::class);
    }

    /**
     * @template TDiscoveryAttribute of DiscoveryAttribute
     *
     * @param class-string<TDiscoveryAttribute> $attributeClass
     *
     * @return DiscoveryAttribute|null
     */
    public function getAttribute(string $attributeClass): ?DiscoveryAttribute
    {
        $attributes = $this->method->getAttributes($attributeClass, ReflectionAttribute::IS_INSTANCEOF);

        if (! count($attributes)) {
            return null;
        }

        return $attributes[0]->newInstance();
    }

    /**
     * Format a parameter for URI generation, taking optional parameters into account
     *
     * @param ReflectionParameter $parameter The parameter to format
     * @return string The formatted parameter string for URI (e.g., "{user}" or "{user?}")
     */
    private function formatParameterForUri(ReflectionParameter $parameter): string
    {
        $paramName = $parameter->getName();
        $isOptional = $this->isParameterOptional($parameter);

        return $isOptional ? "{{$paramName}?}" : "{{$paramName}}";
    }

    /**
     * Determine if a parameter is optional
     *
     * @param ReflectionParameter $parameter The parameter to check
     * @return bool True if the parameter is optional, false otherwise
     */
    private function isParameterOptional(ReflectionParameter $parameter): bool
    {
        // Check if the parameter has a default value
        if ($parameter->isDefaultValueAvailable()) {
            return true;
        }

        // Check if the parameter is nullable (syntax ?Type)
        if ($parameter->allowsNull()) {
            return true;
        }

        // Check if the parameter has a nullable type (syntax ?Type)
        $type = $parameter->getType();
        if ($type && $type->allowsNull()) {
            return true;
        }

        return false;
    }
}
