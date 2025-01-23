<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class AddControllerUriToActions implements PendingRouteTransformer
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
                $originalActionUri = $action->uri;

                $action->uri = $pendingRoute->uri;

                if ($originalActionUri) {
                    $action->uri .= "/{$originalActionUri}";
                }
            });
        });

        return $pendingRoutes;
    }
}
