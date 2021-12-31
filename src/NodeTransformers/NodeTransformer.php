<?php

namespace Spatie\RouteDiscovery\NodeTransformers;

use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\NodeTree\Node;

interface NodeTransformer
{
    /** @param Collection<Node> $nodes */
    public function apply(Collection $nodes): void;
}
