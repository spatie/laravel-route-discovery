<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Nesting\Nested;

use const Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Nesting\Nested\__METHOD__;

class ChildController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
