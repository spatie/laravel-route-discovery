<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\DoNotDiscoverController;

use Spatie\RouteDiscovery\Attributes\DoNotDiscover;

#[DoNotDiscover]
class DoNotDiscoverController
{
    public function doNotDiscoverThisController()
    {
    }
}
