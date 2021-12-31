<?php

namespace Spatie\RouteDiscovery\NodeTree;

use function collect;
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
    public array $middleware = [];
    public array $wheres = [];
    public ?string $name = null;

    public function __construct(ReflectionMethod $method, string $controllerClass)
    {
        $this->method = $method;

        $this->uri = $this->relativeUri();

        $this->methods = $this->discoverHttpMethods();

        $this->action = [$controllerClass, $method->name];
    }

    public function relativeUri(): ?string
    {
        /** @var ReflectionParameter $modelParameter */
        $modelParameter = collect($this->method->getParameters())->first(function (ReflectionParameter $parameter) {
            return is_a($parameter->getType()?->getName(), Model::class, true);
        });

        $uri = '';

        if (! in_array($this->method->getName(), $this->commonControllerMethodNames())) {
            $uri = Str::kebab($this->method->getName());
        }

        if ($modelParameter) {
            if ($uri !== '') {
                $uri .= '/';
            }

            $uri .= "{{$modelParameter->getName()}}";
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
        return ['index', '__invoke', 'get', 'show', 'store', 'update', 'destroy', 'delete'];
    }
}
