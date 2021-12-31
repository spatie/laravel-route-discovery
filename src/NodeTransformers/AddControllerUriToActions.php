<?php

namespace Spatie\RouteDiscovery\NodeTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\NodeTree\Action;
use Spatie\RouteDiscovery\NodeTree\Node;

class AddControllerUriToActions implements NodeTransformer
{
    /** @param Collection<Node> $nodes */
    public function apply(Collection $nodes): void
    {
        $nodes->each(function (Node $node) {
            $node->actions->each(function (Action $action) use ($node) {
                $originalActionUri = $action->uri;

                $action->uri = $node->uri;

                if ($originalActionUri) {
                    $action->uri .= "/{$originalActionUri}";
                }
            });
        });
    }
}
