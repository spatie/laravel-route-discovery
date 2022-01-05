<?php

namespace Spatie\RouteDiscovery;

use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteFactory;
use Spatie\RouteDiscovery\PendingRouteTransformers\PendingRouteTransformer;
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

        $pendingRoutes = $this->convertToPendingRoutes($directory);

        $pendingRoutes = $this->transformNodes($pendingRoutes);

        $this->registerRoutes($pendingRoutes);
    }

    /**
     * @param string $directory
     *
     * @return Collection<\Spatie\RouteDiscovery\PendingRoutes\PendingRoute>
     */
    protected function convertToPendingRoutes(string $directory): Collection
    {
        $files = (new Finder())->files()->depth(0)->name('*.php')->in($directory);

        $pendingRouteFactory = new PendingRouteFactory(
            $this->basePath,
            $this->rootNamespace,
            $this->registeringDirectory,
        );

        $pendingRoutes = collect($files)
            ->map(fn (SplFileInfo $file) => $pendingRouteFactory->make($file))
            ->filter();

        collect((new Finder())->directories()->depth(0)->in($directory))
            ->flatMap(function (SplFileInfo $subDirectory) {
                return $this->convertToPendingRoutes($subDirectory);
            })
            ->filter()
            /** @phpstan-ignore-next-line */
            ->each(fn (PendingRoute $pendingRoute) => $pendingRoutes->push($pendingRoute));

        return $pendingRoutes;
    }

    /**
     * @param Collection<PendingRoute> $pendingRoutes
     *
     * @return Collection<PendingRoute> $pendingRoutes
     */
    protected function transformNodes(Collection $pendingRoutes): Collection
    {
        /** @var array<int, class-string<PendingRouteTransformer>> $transformers */
        $transformers = config('route-discovery.pending_route_transformers');

        /** @var Collection<int, PendingRouteTransformer> */
        $transformers = collect($transformers)
            ->map(fn (string $transformerClass): PendingRouteTransformer => app($transformerClass));

        foreach ($transformers as $transformer) {
            $pendingRoutes = $transformer->transform($pendingRoutes);
        }

        return $pendingRoutes;
    }

    protected function registerRoutes(Collection $pendingRoutes): void
    {
        $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            $pendingRoute->actions->each(function (PendingRouteAction $action) {
                $route = $this->router->addRoute($action->methods, $action->uri, $action->action);

                $route->middleware($action->middleware);

                /** @phpstan-ignore-next-line */
                $route->name($action->name);

                if (count($action->wheres)) {
                    $route->setWheres($action->wheres);
                }

                if ($action->domain) {
                    $route->domain($action->domain);
                }
            });
        });
    }
}
