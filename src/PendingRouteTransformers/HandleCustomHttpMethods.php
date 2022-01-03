<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;

class HandleCustomHttpMethods implements PendingRouteTransformer
{
    /**
     * @param Collection<PendingRoute> $pendingRoutes
     *
     * @return Collection<PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            /** @phpstan-ignore-next-line */
            $pendingRoute->actions->each(function (PendingRouteAction $action) {
                if (! $routeAttribute = $action->getRouteAttribute()) {
                    return;
                }

                if (! $httpMethods = $routeAttribute->methods) {
                    return;
                }

                return $action->methods = $httpMethods;
            });
        });

        return $pendingRoutes;
    }
}
