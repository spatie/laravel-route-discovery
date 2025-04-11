<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class AddDefaultRouteName implements PendingRouteTransformer
{
    /**
     * @param Collection<int, PendingRoute> $pendingRoutes
     *
     * @return Collection<int, PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            $pendingRoute->actions
                ->reject(fn (PendingRouteAction $action): bool => (bool)$action->name)
                ->each(fn (PendingRouteAction $action) => $action->name = $this->generateRouteName($action));
        });

        return $pendingRoutes;
    }

    protected function generateRouteName(PendingRouteAction $pendingRouteAction): string
    {
        /** @var array<int, non-empty-string> $segments */
        $segments = collect(explode('/', $pendingRouteAction->uri))
            ->reject(fn (string $segment) => str_starts_with($segment, '{'))
            ->filter()
            ->all();

        $methodName = $this->discoverMethodRouteName($pendingRouteAction);

        if ($methodName !== null && $methodName !== end($segments)) {
            // $segments[] = $methodName;
            array_pop($segments);
            $segments[] = $methodName;
        }

        return implode('.', $segments);
    }

    /**
     * @param PendingRouteAction $pendingRouteAction
     * @return non-empty-string|null
     */
    protected function discoverMethodRouteName(PendingRouteAction $pendingRouteAction): ?string
    {
        $defaultRouteNames = config('route-discovery.default_route_names',[]);

        // $defaultRouteNames += [
        //     'show' => 'show',
        //     'store' => 'store',
        //     'edit' => 'edit',
        //     'update' => 'update',
        //     'destroy' => 'destroy',
        //     'delete' => 'delete',
        // ];

        return $defaultRouteNames[$pendingRouteAction->method->name] ?? null;
    }
}
