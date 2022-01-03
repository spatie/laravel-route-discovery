<?php

namespace Spatie\RouteDiscovery\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Prefix implements DiscoveryAttribute
{
    public function __construct(
        public string $prefix
    ) {
    }
}
