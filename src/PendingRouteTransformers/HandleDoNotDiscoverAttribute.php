<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\Attributes\DoNotDiscover;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class HandleDoNotDiscoverAttribute implements PendingRouteTransformer
{
    /**
     * @param Collection<int, PendingRoute> $pendingRoutes
     *
     * @return Collection<int, PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        return $pendingRoutes
            ->reject(fn (PendingRoute $pendingRoute): bool => (bool)$pendingRoute->getAttribute(DoNotDiscover::class))
            ->each(function (PendingRoute $pendingRoute) {
                /** @var Collection<int, PendingRouteAction> $actions */
                $actions = $pendingRoute
                    ->actions
                    ->reject(fn (PendingRouteAction $action): bool => (bool)$action->getAttribute(DoNotDiscover::class));

                $pendingRoute->actions = $actions;
            });
    }
}
