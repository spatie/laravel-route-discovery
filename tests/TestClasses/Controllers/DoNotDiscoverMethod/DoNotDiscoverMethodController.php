<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\DoNotDiscoverMethod;

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
