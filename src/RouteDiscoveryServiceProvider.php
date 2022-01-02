<?php

namespace Spatie\RouteDiscovery;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\RouteDiscovery\Discovery\Discover;

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

        $this->registerRoutesForViews();

        /*
        $routeRegistrar = (new OldRouteRegistrar(app()->router))
            ->useRootNamespace(app()->getNamespace())
            ->useMiddleware(config('route-attributes.middleware') ?? []);

        collect($this->getRouteDirectories())->each(fn (string $directory) => $routeRegistrar->registerDirectory($directory));
        */
    }

    protected function shouldRegisterRoutes(): bool
    {

        if ($this->app->routesAreCached()) {
            return false;
        }

        return true;
    }

    protected function getRouteDirectories(): array
    {
        $testClassDirectory = __DIR__ . '/../tests/TestClasses';

        return app()->runningUnitTests() && file_exists($testClassDirectory)
            ? (array)$testClassDirectory
            : config('route-attributes.directories');
    }

    public function registerRoutesForViews(): self
    {
        collect(config('route-discovery.discover_views_in_directory'))
            ->each(function(array|string $directories, int|string $prefix) {
                if (is_numeric($prefix)) {
                    $prefix = '';
                }

                $directories = Arr::wrap($directories);

                foreach($directories as $directory) {
                    Route::prefix($prefix)->group(function() use ($prefix, $directory) {
                        Discover::views()->in($directory);
                    });
                }
            });

        return $this;
    }
}
