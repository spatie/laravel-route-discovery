<?php

namespace Spatie\RouteDiscovery\NodeTree;

use Illuminate\Support\Collection;
use SplFileInfo;

class Node
{
    /**
     * @param \SplFileInfo $fileInfo
     * @param string $fullQualifiedClassName
     * @param \Illuminate\Support\Collection<\Spatie\RouteDiscovery\NodeTree\Action> $actions
     */
    public function __construct(
        public SplFileInfo $fileInfo,
        public string $uri,
        public string $fullQualifiedClassName,
        public Collection $actions,
    ) {

    }
}
