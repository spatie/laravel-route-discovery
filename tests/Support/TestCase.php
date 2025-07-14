<?php

namespace Spatie\RouteDiscovery\Tests\Support;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Arr;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelRay\RayServiceProvider;
use Spatie\RouteDiscovery\RouteDiscoveryServiceProvider;
use Spatie\RouteDiscovery\RouteRegistrar;

class TestCase extends Orchestra
{
    protected RouteRegistrar $routeRegistrar;

    protected function setUp(): void
    {
        parent::setUp();

        $router = app()->router;

        $this->routeRegistrar = (new RouteRegistrar($router))
            ->useBasePath($this->getTestPath('Support'))
            ->useRootNamespace('Spatie\RouteDiscovery\Tests\Support\\');
    }

    protected function getPackageProviders($app)
    {
        return [
            RayServiceProvider::class,
            RouteDiscoveryServiceProvider::class,
        ];
    }

    public function getTestPath(string $directory = null): string
    {
        return realpath(__DIR__. '/..' . ($directory ? '/' . $directory : ''));
    }

    public function assertRegisteredRoutesCount(int $expectedNumber): self
    {
        $actualNumber = $this->getRouteCollection()->count();

        $this->assertEquals($expectedNumber, $actualNumber);

        return $this;
    }

    public function assertRouteRegistered(
        string $controller,
        string $controllerMethod = 'myMethod',
        string | array $httpMethods = ['get'],
        string $uri = null,
        string | array $middleware = [],
        ?string $name = null,
        ?string $domain = null,
        ?array $wheres = null,
        bool $withTrashed = false,
    ): self {
        if (! is_array($middleware)) {
            $middleware = Arr::wrap($middleware);
        }

        $routeRegistered = collect($this->getRouteCollection()->getRoutes())
            ->contains(function (Route $route) use ($name, $middleware, $controllerMethod, $controller, $uri, $httpMethods, $domain, $wheres, $withTrashed) {
                foreach (Arr::wrap($httpMethods) as $httpMethod) {
                    if (! in_array(strtoupper($httpMethod), $route->methods)) {
                        return false;
                    }
                }

                if ($uri !== null) {
                    if ($route->uri() !== $uri) {
                        return false;
                    }
                }
                $routeController = $route->getAction(0) ?? get_class($route->getController());

                if ($routeController !== $controller) {
                    return false;
                }
                $routeMethod = $route->getAction(1) ?? $route->getActionMethod();
                if ($route->getActionMethod() === get_class($route->getController())) {
                    $routeMethod = '__invoke';
                }

                if ($routeMethod !== $controllerMethod) {
                    return false;
                }

                if (array_diff($route->middleware(), $middleware)) {
                    return false;
                }

                if ($name !== null) {
                    if ($route->getName() !== $name) {
                        return false;
                    }
                }

                if ($route->getDomain() !== $domain) {
                    return false;
                }

                if ($route->allowsTrashedBindings() !== $withTrashed) {
                    return false;
                }

                if ($wheres !== null) {
                    if ($wheres !== $route->wheres) {
                        return false;
                    }
                }

                return true;
            });

        $this->assertTrue($routeRegistered, 'The expected route was not registered');

        return $this;
    }

    public function getRouteCollection(): RouteCollection
    {
        return tap(new RouteCollection, function ($collection) {
            collect(app()->router->getRoutes()->getRoutes())
                ->reject(fn ($route) => $route->getName() == 'storage.local')
                ->each(fn ($route) => $collection->add($route));
        });
    }

    protected function registerControllersFromConfigFile(): self
    {
        (new RouteDiscoveryServiceProvider($this->app))->registerRoutesForControllers();

        return $this;
    }

    protected function registerViewsFromConfigFile(): self
    {
        (new RouteDiscoveryServiceProvider($this->app))->registerRoutesForViews();

        return $this;
    }
}
