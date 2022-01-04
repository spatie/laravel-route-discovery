<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DoNotDiscoverController;

use Spatie\RouteDiscovery\Attributes\DoNotDiscover;

class DoNotDiscoverThisMethodController
{
    public function method()
    {
    }

    #[DoNotDiscover]
    public function doNotDiscoverMethod()
    {
    }
}
