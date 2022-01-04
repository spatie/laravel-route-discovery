<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class HandleUrisOfNestedControllers implements PendingRouteTransformer
{
    /**
     * @param Collection<PendingRoute> $pendingRoutes
     *
     * @return Collection<PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        $pendingRoutes->each(function (PendingRoute $parentPendingRoute) use ($pendingRoutes) {
            $childNode = $this->findChild($pendingRoutes, $parentPendingRoute);

            if (! $childNode) {
                return;
            }

            /** @var PendingRouteAction $parentAction */
            $parentAction = $parentPendingRoute->actions->first(function (PendingRouteAction $action) {
                return $action->method->name === 'show';
            });

            /*
            if (! (bool)$parentAction) {
                return;
            }
            */

            $childNode->actions->each(function (PendingRouteAction $action) use ($parentPendingRoute, $parentAction) {
                $result = Str::replace($parentPendingRoute->uri, $parentAction->uri, $action->uri);

                $action->uri = $result;
            });
        });

        return $pendingRoutes;
    }

    protected function findChild(Collection $pendingRoutes, PendingRoute $parentRouteAction): ?PendingRoute
    {
        $childNamespace = $parentRouteAction->childNamespace();

        return $pendingRoutes->first(
            fn (PendingRoute $potentialChildRoute) => $potentialChildRoute->namespace() === $childNamespace
        );
    }
}
