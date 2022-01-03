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
                $attributes = $action->method->getAttributes(RouteAttribute::class, ReflectionAttribute::IS_INSTANCEOF);

                foreach ($attributes as $attribute) {
                    try {
                        $attributeClass = $attribute;

                        if ($attributeClass instanceof ReflectionAttribute) {
                            $attributeClass = $attribute->newInstance();
                        }
                    } catch (Throwable) {
                        continue;
                    }

                    if (! $attributeClass instanceof Route) {
                        $attributeClass = Route::new();
                    }

                    if ($uri = $attributeClass->uri) {
                        $action->uri = $uri;
                    }

                    if ($httpMethods = $attributeClass->methods) {
                        $action->methods = $httpMethods;
                    }

                    if ($name = $attributeClass->name) {
                        $action->name = $name;
                    }

                    $action->middleware = $attributeClass->middleware;
                }
            });
        });
    }
}
