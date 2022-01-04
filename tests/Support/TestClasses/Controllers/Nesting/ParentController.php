<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Nesting;

use const Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Nesting\__METHOD__;

class ParentController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
