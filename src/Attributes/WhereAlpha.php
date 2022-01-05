<?php


namespace Spatie\RouteDiscovery\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class WhereAlpha extends Where
{
    public function __construct(string $param)
    {
        $this->param = $param;
        $this->constraint = '[a-zA-Z]+';
    }
}
