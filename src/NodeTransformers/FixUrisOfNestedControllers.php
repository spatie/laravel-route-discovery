<?php

namespace Spatie\RouteDiscovery\NodeTransformers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\RouteDiscovery\NodeTree\Action;
use Spatie\RouteDiscovery\NodeTree\Node;

class FixUrisOfNestedControllers implements NodeTransformer
{
    public function transform(Collection $nodes): void
    {
        $nodes->each(function(Node $parentNode) use ($nodes) {
            $childNode = $this->findChild($nodes, $parentNode);

            if (! $childNode) {
                return;
            }

            /** @var Action $parentAction */
            $parentAction = $parentNode->actions->first(function(Action $action) {
                return $action->method->name === 'show';
            });

            if (! $parentAction) {
                return;
            }

            $childNode->actions->each(function(Action $action) use ($parentNode, $parentAction) {
                $result = Str::replace($parentNode->uri, $parentAction->uri, $action->uri);

                $action->uri = $result;
            });
        });
    }

    protected function findChild(Collection $nodes, Node $parentNode): ?Node
    {
        $childNamespace = $parentNode->childNamespace();

        return $nodes->first(
            fn(Node $potentialChildNode) => $potentialChildNode->namespace() === $childNamespace
        );
    }
}
