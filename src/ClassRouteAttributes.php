<?php

namespace Spatie\RouteDiscovery;

use ReflectionClass;
use Spatie\RouteDiscovery\Attributes\Domain;
use Spatie\RouteDiscovery\Attributes\DomainFromConfig;
use Spatie\RouteDiscovery\Attributes\Group;
use Spatie\RouteDiscovery\Attributes\Middleware;
use Spatie\RouteDiscovery\Attributes\Prefix;
use Spatie\RouteDiscovery\Attributes\Resource;
use Spatie\RouteDiscovery\Attributes\RouteAttribute;
use Spatie\RouteDiscovery\Attributes\Where;

class ClassRouteAttributes
{
    private ReflectionClass $class;

    public function __construct(ReflectionClass $class)
    {
        $this->class = $class;
    }

    public function prefix(): ?string
    {
        /** @var \Spatie\RouteDiscovery\Attributes\Prefix $attribute */
        if (! $attribute = $this->getAttribute(Prefix::class)) {
            return null;
        }

        return $attribute->prefix;
    }

    public function domain(): ?string
    {
        /** @var \Spatie\RouteDiscovery\Attributes\Domain $attribute */
        if (! $attribute = $this->getAttribute(Domain::class)) {
            return null;
        }

        return $attribute->domain;
    }

    public function domainFromConfig(): ?string
    {
        /** @var \Spatie\RouteDiscovery\Attributes\DomainFromConfig $attribute */
        if (! $attribute = $this->getAttribute(DomainFromConfig::class)) {
            return null;
        }

        return config($attribute->domain);
    }

    public function groups(): array
    {
        $groups = [];

        /** @var ReflectionClass[] $attributes */
        $attributes = $this->class->getAttributes(Group::class, \ReflectionAttribute::IS_INSTANCEOF);
        if (count($attributes) > 0) {
            foreach ($attributes as $attribute) {
                $attributeClass = $attribute->newInstance();
                $groups[] = [
                    'domain' => $attributeClass->domain,
                    'prefix' => $attributeClass->prefix,
                    'where' => $attributeClass->where,
                    'as' => $attributeClass->as,
                ];
            }
        } else {
            $groups[] = [
                'domain' => $this->domainFromConfig() ?? $this->domain(),
                'prefix' => $this->prefix(),
            ];
        }

        return $groups;
    }

    public function resource(): ?string
    {
        /** @var \Spatie\RouteDiscovery\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->resource;
    }

    public function apiResource(): ?string
    {
        /** @var \Spatie\RouteDiscovery\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->apiResource;
    }

    public function except(): string | array | null
    {
        /** @var \Spatie\RouteDiscovery\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->except;
    }

    public function only(): string | array | null
    {
        /** @var \Spatie\RouteDiscovery\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->only;
    }

    public function names(): string | array | null
    {
        /** @var \Spatie\RouteDiscovery\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->names;
    }

    public function middleware(): array
    {
        /** @var \Spatie\RouteDiscovery\Attributes\Middleware $attribute */
        if (! $attribute = $this->getAttribute(Middleware::class)) {
            return [];
        }

        return $attribute->middleware;
    }

    public function wheres(): array
    {
        $wheres = [];
        /** @var ReflectionClass[] $attributes */
        $attributes = $this->class->getAttributes(Where::class, \ReflectionAttribute::IS_INSTANCEOF);
        foreach ($attributes as $attribute) {
            $attributeClass = $attribute->newInstance();
            $wheres[$attributeClass->param] = $attributeClass->constraint;
        }

        return $wheres;
    }

    protected function getAttribute(string $attributeClass): ?RouteAttribute
    {
        $attributes = $this->class->getAttributes($attributeClass, \ReflectionAttribute::IS_INSTANCEOF);

        if (! count($attributes)) {
            return null;
        }

        return $attributes[0]->newInstance();
    }
}
