<?php

namespace Spatie\RouteDiscovery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Attributes\RouteAttribute;
use Spatie\RouteDiscovery\Attributes\Where;
use Spatie\RouteDiscovery\Attributes\WhereAttribute;
use Spatie\RouteDiscovery\Discovery\Action;
use Spatie\RouteDiscovery\Discovery\Middleware\ApplyControllerUriToActions;
use Spatie\RouteDiscovery\Discovery\Node;
use Spatie\RouteDiscovery\Discovery\NodeFactory;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Throwable;

class NewRouteRegistrar
{
    private Router $router;

    protected string $basePath;

    protected string $rootNamespace;

    protected array $middleware = [];

    protected string $registeringDirectory = '';

    public function __construct(Router $router)
    {
        $this->router = $router;

        $this->basePath = app()->path();
    }

    public function useBasePath(string $basePath): self
    {
        $this->basePath = $basePath;

        return $this;
    }

    public function useRootNamespace(string $rootNamespace): self
    {
        $this->rootNamespace = $rootNamespace;

        return $this;
    }

    public function useMiddleware(string|array $middleware): self
    {
        $this->middleware = Arr::wrap($middleware);

        return $this;
    }

    public function middleware(): array
    {
        return $this->middleware ?? [];
    }

    public function registerDirectory(string $directory): void
    {
        $nodes = $this->convertToNodes($directory);

        $this->applyNodeMiddleware($nodes);

        $this->registerRoutes($nodes);
    }

    /**
     * @param string $directory
     *
     * @return Collection<\Spatie\RouteDiscovery\Discovery\Node>
     */
    protected function convertToNodes(string $directory): Collection
    {
        $files = (new Finder())->files()->depth(0)->name('*.php')->in($directory);

        $nodeFactory = new NodeFactory($this->basePath, $this->rootNamespace, $this->registeringDirectory);

        $nodes = collect($files)
            ->map(function (SplFileInfo $file) use ($nodeFactory, $directory) {
                return $nodeFactory->make($file);
            })
            ->filter();

        collect((new Finder())->directories()->depth(0)->in($directory))
            ->each(function(SplFileInfo $subDirectory) {
                $nodes = $this->convertToNodes($subDirectory);
            });

        return $nodes;

    }

    private function applyNodeMiddleware($nodes): void
    {
        collect([
            new ApplyControllerUriToActions(),
        ])
        ->each(fn($middleware) => $middleware->apply($nodes));
    }

    private function registerRoutes(Collection $nodes): void
    {
        $nodes->each(function(Node $node) {
            $node->actions->each(function(Action $action) {
                $this->router->addRoute($action->methods, $action->uri, $action->action);
            });

            $this->registerRoutes($node->children);
        });
    }
}
