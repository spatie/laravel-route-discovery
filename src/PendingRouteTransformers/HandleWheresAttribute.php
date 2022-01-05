<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\Attributes\WhereAttribute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class HandleWheresAttribute implements PendingRouteTransformer
{
    public function transform(Collection $pendingRoutes): Collection
    {
        $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            $pendingRoute->actions->each(function (PendingRouteAction $action) use ($pendingRoute) {
                if ($pendingRouteWhereAttribute = $pendingRoute->getAttribute(WhereAttribute::class)) {
                    /** @phpstan-ignore-next-line */
                    $action->addWhere($pendingRouteWhereAttribute);
                }

                if ($actionWhereAttribute = $action->getAttribute(WhereAttribute::class)) {
                    /** @phpstan-ignore-next-line */
                    $action->addWhere($actionWhereAttribute);
                }
            });
        });

        return $pendingRoutes;
    }
}
