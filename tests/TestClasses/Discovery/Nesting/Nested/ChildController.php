<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Discovery\Nesting\Nested;

class ChildController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
