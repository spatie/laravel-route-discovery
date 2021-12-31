<?php

namespace Spatie\RouteDiscovery\Discovery\Middleware;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\Discovery\Action;
use Spatie\RouteDiscovery\Discovery\Node;

class ApplyControllerUriToActions
{
    /**
     * @param \Illuminate\Support\Collection $nodes
     */
    public function apply(Collection $nodes)
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
