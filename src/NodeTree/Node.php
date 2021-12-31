<?php

namespace Spatie\RouteDiscovery\NodeTree;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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

    public function namespace(): string
    {
        return Str::beforeLast($this->fullQualifiedClassName, '\\');
    }

    public function shortControllerName(): string
    {
        return Str::of($this->fullQualifiedClassName)
            ->afterLast('\\')
            ->beforeLast('Controller');
    }

    public function childNamespace(): string
    {
        return $this->namespace() . '\\' . $this->shortControllerName();
    }
}
