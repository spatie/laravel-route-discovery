<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\DoNotDiscoverController;

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
