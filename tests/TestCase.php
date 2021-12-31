<?php

namespace Spatie\RouteDiscovery\Tests;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Arr;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelRay\RayServiceProvider;
use Spatie\RouteDiscovery\RouteRegistrar;
use Spatie\RouteDiscovery\RouteDiscoveryServiceProvider;
use Spatie\RouteDiscovery\OldRouteRegistrar;
use Spatie\RouteDiscovery\Tests\TestClasses\Middleware\AnotherTestMiddleware;

class TestCase extends Orchestra
{
    protected OldRouteRegistrar $oldRouteRegistrar;

    protected RouteRegistrar $routeRegistrar;

    protected function setUp(): void
    {
        parent::setUp();

        $router = app()->router;

        $this->oldRouteRegistrar = (new OldRouteRegistrar($router))
            ->useBasePath($this->getTestPath())
            ->useMiddleware([AnotherTestMiddleware::class])
            ->useRootNamespace('Spatie\RouteDiscovery\Tests\\');

        $this->routeRegistrar = (new RouteRegistrar($router))
            ->useBasePath($this->getTestPath())
            ->useMiddleware([AnotherTestMiddleware::class])
            ->useRootNamespace('Spatie\RouteDiscovery\Tests\\');
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
        return __DIR__ . ($directory ? '/' . $directory : '');
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
        string $uri = 'my-method',
        string | array $middleware = [],
        ?string $name = null,
        ?string $domain = null,
        ?array $wheres = []
    ): self {
        if (! is_array($middleware)) {
            $middleware = Arr::wrap($middleware);
        }

        $routeRegistered = collect($this->getRouteCollection()->getRoutes())
            ->contains(function (Route $route) use ($name, $middleware, $controllerMethod, $controller, $uri, $httpMethods, $domain, $wheres) {
                foreach (Arr::wrap($httpMethods) as $httpMethod) {
                    if (! in_array(strtoupper($httpMethod), $route->methods)) {
                        return false;
                    }
                }
                if ($route->uri() !== $uri) {
                    return false;
                }

                $routeController = $route->getAction(0) ?? get_class($route->getController());

                if ($routeController !== $controller) {
                    return false;
                }
                $routeMethod = $route->getAction(1) ?? $route->getActionMethod();

                if ($routeMethod !== $controllerMethod) {
                    return false;
                }
                if (array_diff($route->middleware(), array_merge($middleware, $this->oldRouteRegistrar->middleware()))) {
                    return false;
                }

                if ($route->getName() !== $name) {
                    return false;
                }


                if ($route->getDomain() !== $domain) {
                    return false;
                }

                if ($wheres !== $route->wheres) {
                    return false;
                }

                return true;
            });

        $this->assertTrue($routeRegistered, 'The expected route was not registered');

        return $this;
    }

    protected function getRouteCollection(): RouteCollection
    {
        return app()->router->getRoutes();
    }
}
