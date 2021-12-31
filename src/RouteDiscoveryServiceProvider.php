<?php

namespace Spatie\RouteDiscovery;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RouteDiscoveryServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-route-discovery')
            ->hasConfigFile();
    }

    public function packageRegistered()
    {
        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        if (! $this->shouldRegisterRoutes()) {
            return;
        }

        $routeRegistrar = (new OldRouteRegistrar(app()->router))
            ->useRootNamespace(app()->getNamespace())
            ->useMiddleware(config('route-attributes.middleware') ?? []);

        collect($this->getRouteDirectories())->each(fn (string $directory) => $routeRegistrar->registerDirectory($directory));
    }

    private function shouldRegisterRoutes(): bool
    {
        if (! config('route-attributes.enabled')) {
            return false;
        }

        if ($this->app->routesAreCached()) {
            return false;
        }

        return true;
    }

    private function getRouteDirectories(): array
    {
        $testClassDirectory = __DIR__ . '/../tests/TestClasses';

        return app()->runningUnitTests() && file_exists($testClassDirectory)
            ? (array)$testClassDirectory
            : config('route-attributes.directories');
    }
}
