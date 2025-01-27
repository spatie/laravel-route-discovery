<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\Attributes\Where;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class HandleWheresAttribute implements PendingRouteTransformer
{
    /**
     * @param Collection<int, PendingRoute> $pendingRoutes
     *
     * @return Collection<int, PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            $pendingRoute->actions->each(function (PendingRouteAction $action) use ($pendingRoute) {
                if ($pendingRouteWhereAttribute = $pendingRoute->getAttribute(Where::class)) {
                    if ($pendingRouteWhereAttribute instanceof Where) {
                        $action->addWhere($pendingRouteWhereAttribute);
                    }
                }

                if ($actionWhereAttribute = $action->getAttribute(Where::class)) {
                    if ($actionWhereAttribute instanceof Where) {
                        $action->addWhere($actionWhereAttribute);
                    }
                }
            });
        });

        return $pendingRoutes;
    }
}
