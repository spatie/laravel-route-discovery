<?php

namespace Spatie\RouteDiscovery\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class Where implements DiscoveryAttribute
{
    public const alpha = '[a-zA-Z]+';
    public const numeric = '[0-9]+';
    public const alphanumeric = '[a-zA-Z0-9]+';
    public const uuid = '[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}';

    public function __construct(
        public string $param,
        public string $constraint,
    ) {
    }
}
