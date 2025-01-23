<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;

interface PendingRouteTransformer
{
    /**
     * @param Collection<int, PendingRoute> $pendingRoutes
     * @return Collection<int, PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection;
}
