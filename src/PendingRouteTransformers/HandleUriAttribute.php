<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class HandleUriAttribute implements PendingRouteTransformer
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

                if (! isset($routeAttribute->uri)) {
                    return;
                }

                if (! $routeAttribute->uri) {
                    return;
                }

                $baseUri = Str::beforeLast($action->uri, '/');
                $action->uri = $baseUri . '/' . $routeAttribute->uri;
            });
        });

        return $pendingRoutes;
    }
}
