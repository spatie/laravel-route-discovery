<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DoNotDiscoverConstructor;

class DoNotDiscoverConstructorController
{
    public function __construct()
    {
    }
}
