<?php

namespace Spatie\RouteDiscovery\Discovery;

use Illuminate\Support\Collection;
use SplFileInfo;

class Node
{
    /**
     * @param \SplFileInfo $fileInfo
     * @param string $fullQualifiedClassName
     * @param \Illuminate\Support\Collection<\Spatie\RouteDiscovery\Discovery\Action> $actions
     * @param \Illuminate\Support\Collection<\Spatie\RouteDiscovery\Discovery\Node> $children

     */
    public function __construct(
        public SplFileInfo $fileInfo,
        public string $uri,
        public string $fullQualifiedClassName,
        public Collection $actions,
        public Collection $children,
    ) {
    }
}
