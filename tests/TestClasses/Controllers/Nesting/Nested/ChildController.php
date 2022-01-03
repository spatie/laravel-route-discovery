<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Nesting\Nested;

class ChildController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
