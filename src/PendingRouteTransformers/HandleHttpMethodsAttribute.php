<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class HandleHttpMethodsAttribute implements PendingRouteTransformer
{
    /**
     * @param Collection<int, PendingRoute> $pendingRoutes
     *
     * @return Collection<int, PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            $pendingRoute->actions->each(function (PendingRouteAction $action) {
                if (! $routeAttribute = $action->getRouteAttribute()) {
                    return;
                }

                if (! $routeAttribute instanceof Route) {
                    return;
                }

                if (! $httpMethods = $routeAttribute->methods) {
                    return;
                }

                $action->methods = $httpMethods;
            });
        });

        return $pendingRoutes;
    }
}
