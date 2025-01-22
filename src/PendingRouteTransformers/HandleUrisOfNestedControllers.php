<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionParameter;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;

class HandleUrisOfNestedControllers implements PendingRouteTransformer
{
    /**
     * @param Collection<int, PendingRoute> $pendingRoutes
     *
     * @return Collection<int, PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        $pendingRoutes->each(function (PendingRoute $parentPendingRoute) use ($pendingRoutes) {
            $childrenNodes = $this->findChild($pendingRoutes, $parentPendingRoute);

            if (! $childrenNodes->count()) {
                return;
            }

            /** @var PendingRouteAction|null $parentAction */
            $parentAction = $parentPendingRoute->actions->first(function (PendingRouteAction $action) {
                return in_array($action->method->name, ['show', 'edit', 'update', 'destroy', 'delete']);
            });

            if (is_null($parentAction)) {
                return;
            }

            $childrenNodes->each(function (PendingRoute $childNode) use ($parentPendingRoute, $parentAction) {
                $childNode->actions->each(function (PendingRouteAction $action) use ($parentPendingRoute, $parentAction) {
                    $paramsToRemove = $action->modelParameters()
                        ->filter(
                            fn (ReflectionParameter $parameter) => $parentAction
                            ->modelParameters()
                            ->contains(
                                fn (ReflectionParameter $parentParameter) => $parentParameter->getName() === $parameter->getName()
                            )
                        );
                    $result = Str::of($action->uri)
                        ->replace(
                            $paramsToRemove->map(fn (ReflectionParameter $parameter) => "{{$parameter->getName()}}")->toArray(),
                            ''
                        )
                        ->replace('//', '/')
                        ->replace($parentPendingRoute->uri, $parentAction->uri);

                    $action->uri = $result;
                });
            });
        });

        return $pendingRoutes;
    }

    /**
     * @param Collection<int, PendingRoute> $pendingRoutes
     * @param PendingRoute $parentRouteAction
     * @return Collection<int, PendingRoute>
     */
    protected function findChild(Collection $pendingRoutes, PendingRoute $parentRouteAction): Collection
    {
        $childNamespace = $parentRouteAction->childNamespace();

        return $pendingRoutes->filter(
            fn (PendingRoute $potentialChildRoute) => $potentialChildRoute->namespace() === $childNamespace
        );
    }
}
