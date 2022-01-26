<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class HandleRejectDefaultControllerMethodRoutes implements PendingRouteTransformer
{
    /**
     * Array of FQCN of the classes that methods should be ignored.
     *
     * @var array|string[]
     */
    public array $candidates = [
        // This is the classname on the test, didn't want to mess with autoloading.
        'Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DefaultController\Controller',
        // This is the classname on the production project
        'App\Http\Controllers\Controller',
        Controller::class,
    ];

    /**
     * @param Collection<PendingRoute> $pendingRoutes
     *
     * @return Collection<PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        return $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            // Remove every action that is from the default or abstract controller.
            $pendingRoute->actions = $pendingRoute
                ->actions
                ->reject(fn (PendingRouteAction $pendingRouteAction) => in_array(
                    $pendingRouteAction->method->class,
                    $this->candidates
                ));
        });
    }
}
