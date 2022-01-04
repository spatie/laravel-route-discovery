<?php

namespace Spatie\RouteDiscovery\PendingRoutes;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionClass;
use Spatie\RouteDiscovery\Attributes\DiscoveryAttribute;
use SplFileInfo;

class PendingRoute
{
    /**
     * @param SplFileInfo $fileInfo
     * @param ReflectionClass $class
     * @param string $uri
     * @param string $fullQualifiedClassName
     * @param Collection<PendingRouteAction> $actions
     */
    public function __construct(
        public SplFileInfo $fileInfo,
        public ReflectionClass $class,
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

    /**
     * @template TDiscoveryAttribute of DiscoveryAttribute
     *
     * @param class-string<TDiscoveryAttribute> $attributeClass
     *
     * @return ?TDiscoveryAttribute
     */
    public function getAttribute(string $attributeClass): ?DiscoveryAttribute
    {
        $attributes = $this->class->getAttributes($attributeClass, ReflectionAttribute::IS_INSTANCEOF);

        if (! count($attributes)) {
            return null;
        }

        return $attributes[0]->newInstance();
    }
}
