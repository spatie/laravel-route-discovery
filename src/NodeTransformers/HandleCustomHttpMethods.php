<?php

namespace Spatie\RouteDiscovery\NodeTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\NodeTree\Action;
use Spatie\RouteDiscovery\NodeTree\Node;

class HandleCustomHttpMethods implements NodeTransformer
{
    /** @param Collection<Node> $nodes */
    public function transform(Collection $nodes): void
    {
        $nodes->each(function (Node $node) {
            $node->actions->each(function (Action $action) {
                if (! $routeAttribute = $action->getRouteAttribute()) {
                    return;
                }

                if (! $httpMethods = $routeAttribute->methods) {
                   return;
                }

                return $action->methods = $httpMethods;
            });
        });
    }
}
