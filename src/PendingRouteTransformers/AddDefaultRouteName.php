<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class AddDefaultRouteName implements PendingRouteTransformer
{
    /**
     * @param Collection<PendingRoute> $pendingRoutes
     *
     * @return Collection<PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            $pendingRoute->actions
                ->reject(fn (PendingRouteAction $action) => $action->name)
                /** @phpstan-ignore-next-line */
                ->each(fn (PendingRouteAction $action) => $action->name = $this->generateRouteName($action));
        });

        return $pendingRoutes;
    }

    protected function generateRouteName(PendingRouteAction $pendingRouteAction): string
    {
        return collect(explode('/', $pendingRouteAction->uri))
            ->reject(fn (string $segment) => str_starts_with($segment, '{'))
            ->when(
                $this->discoverMethodRouteName($pendingRouteAction),
                fn (Collection $collection, $name) => $name != $collection->last() ? $collection->push($name) : $collection
            )
            ->join('.');
    }

    /**
     * @param PendingRouteAction $pendingRouteAction
     * @return string|null
     */
    protected function discoverMethodRouteName(PendingRouteAction $pendingRouteAction): ?string
    {
        return match ($pendingRouteAction->method->name) {
            'show' => 'show',
            'store' => 'store',
            'edit' => 'edit',
            'update' => 'update',
            'destroy' => 'destroy',
            'delete' => 'delete',
            default => null,
        };
    }
}
