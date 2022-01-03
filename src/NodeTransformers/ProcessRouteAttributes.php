<?php

namespace Spatie\RouteDiscovery\NodeTransformers;

use Illuminate\Support\Collection;
use ReflectionAttribute;
use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Attributes\RouteAttribute;
use Spatie\RouteDiscovery\NodeTree\Action;
use Spatie\RouteDiscovery\NodeTree\Node;
use Throwable;

class ProcessRouteAttributes implements NodeTransformer
{
    /** @param Collection<Node> $nodes */
    public function transform(Collection $nodes): void
    {
        $nodes->each(function (Node $node) {
            $node->actions->each(function (Action $action) {
                $routeAttribute = $action->getRouteAttribute();

                if (!$routeAttribute) {
                    return null;
                }

                if ($httpMethods = $routeAttribute->methods) {
                    $action->methods = $httpMethods;
                }

                if ($name = $routeAttribute->name) {
                    $action->name = $name;
                }

                $action->middleware = $routeAttribute->middleware;

            });
        });
    }
}
