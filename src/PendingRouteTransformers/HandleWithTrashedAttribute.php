<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class HandleWithTrashedAttribute implements PendingRouteTransformer
{
    /**
     * @param Collection<int, PendingRoute> $pendingRoutes
     *
     * @return Collection<int, PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        return $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            $pendingRoute->actions->each(function (PendingRouteAction $action) use ($pendingRoute) {
                if ($pendingRouteAttribute = $pendingRoute->getRouteAttribute()) {
                    if ($pendingRouteAttribute instanceof Route) {
                        $action->withTrashed = $pendingRouteAttribute->withTrashed;
                    }
                }

                if ($actionAttribute = $action->getRouteAttribute()) {
                    if ($actionAttribute instanceof Route) {
                        $action->withTrashed = $actionAttribute->withTrashed;
                    }
                }
            });
        });
    }
}
