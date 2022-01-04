<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DoNotDiscoverMethod;

use Spatie\RouteDiscovery\Attributes\DoNotDiscover;

class DoNotDiscoverMethodController
{
    public function method()
    {
    }

    #[DoNotDiscover]
    public function doNotDiscoverMethod()
    {
    }
}
