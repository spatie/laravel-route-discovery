<?php

namespace Spatie\RouteDiscovery\Discovery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ReflectionMethod;
use ReflectionParameter;

class Action
{
    public ReflectionMethod $method;
    public string $uri;
    public array $methods = [];
    public array $action;

    public function __construct(ReflectionMethod $method, string $controllerClass)
    {
        $this->method = $method;

        $this->uri = $this->discoverUri();

        $this->methods = $this->discoverHttpMethods();

        $this->action = [$controllerClass, $method->name];
    }

    protected function discoverUri(): ?string
    {
        /** @var ReflectionParameter $modelParameter */
        $modelParameter = collect($this->method->getParameters())->first(function (ReflectionParameter $parameter) {
            return is_a($parameter->getType()?->getName(), Model::class, true);
        });

        $uri = '';

        if (! in_array($this->method->getName(), $this->commonControllerMethodNames())) {
            $uri .= '/' . Str::kebab($this->method->getName());
        }

        if ($modelParameter) {
            $uri .= "/{{$modelParameter->getName()}}";
        }

        return $uri;
    }

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

    protected function commonControllerMethodNames(): array
    {
        return ['index', '__invoke', 'get', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'delete'];
    }
}
