<?php

namespace Spatie\RouteDiscovery\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class Where implements WhereAttribute
{
    public function __construct(
        public string $param,
        public string $constraint,
    ) {
    }
}
