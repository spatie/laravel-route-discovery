<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DoNotDiscoverController;

use Spatie\RouteDiscovery\Attributes\DoNotDiscover;

#[DoNotDiscover]
class DoNotDiscoverController
{
    public function doNotDiscoverThisController()
    {
    }
}
