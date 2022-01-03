<?php

namespace Spatie\RouteDiscovery;

use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\NodeTransformers\AddControllerUriToActions;
use Spatie\RouteDiscovery\NodeTransformers\FixUrisOfNestedControllers;
use Spatie\RouteDiscovery\NodeTransformers\HandleCustomHttpMethods;
use Spatie\RouteDiscovery\NodeTransformers\HandleCustomMiddleware;
use Spatie\RouteDiscovery\NodeTransformers\NodeTransformer;
use Spatie\RouteDiscovery\NodeTransformers\HandleCustomRouteName;
use Spatie\RouteDiscovery\NodeTree\Action;
use Spatie\RouteDiscovery\NodeTree\Node;
use Spatie\RouteDiscovery\NodeTree\NodeFactory;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class RouteRegistrar
{
    private Router $router;

    protected string $basePath;

    protected string $rootNamespace;

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

    public function registerDirectory(string $directory): void
    {
        $this->registeringDirectory = $directory;

        $nodes = $this->convertToNodes($directory);

        $this->transformNodes($nodes);

        $this->registerRoutes($nodes);
    }

    /**
     * @param string $directory
     *
     * @return Collection<\Spatie\RouteDiscovery\NodeTree\Node>
     */
    protected function convertToNodes(string $directory): Collection
    {
        $files = (new Finder())->files()->depth(0)->name('*.php')->in($directory);

        $nodeFactory = new NodeFactory(
            $this->basePath,
            $this->rootNamespace,
            $this->registeringDirectory,
        );

        $nodes = collect($files)
            ->map(function (SplFileInfo $file) use ($nodeFactory) {
                return $nodeFactory->make($file);
            })
            ->filter();

        collect((new Finder())->directories()->depth(0)->in($directory))
            ->flatMap(function (SplFileInfo $subDirectory) {
                return $this->convertToNodes($subDirectory);
            })
            ->filter()
            /** @phpstan-ignore-next-line */
            ->each(fn(Node $node) => $nodes->push($node));

        return $nodes;
    }

    /** @param Collection<Node> $nodes */
    protected function transformNodes(Collection $nodes): void
    {
        collect(config('route-discovery.node_tree_transformers'))
            ->map(fn(string $transformerClass) => app($transformerClass))
            ->each(fn(NodeTransformer $middleware) => $middleware->transform($nodes));
    }

    protected function registerRoutes(Collection $nodes): void
    {
        $nodes->each(function (Node $node) {
            $node->actions->each(function (Action $action) {
                $route = $this->router->addRoute($action->methods, $action->uri, $action->action);

                $route->middleware($action->middleware);

                /** @phpstan-ignore-next-line */
                $route->name($action->name);

                if (count($action->wheres)) {
                    $route->setWheres($action->wheres);
                }
            });
        });
    }
}
