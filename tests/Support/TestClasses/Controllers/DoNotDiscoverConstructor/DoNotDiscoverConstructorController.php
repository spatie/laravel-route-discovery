<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DoNotDiscoverConstructor;

use Spatie\RouteDiscovery\Attributes\DoNotDiscover;

class DoNotDiscoverConstructorController
{
    public function __construct()
    {
    }
}
