<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\RouteOrder;

use Spatie\RouteDiscovery\Attributes\Route;

class AAAController
{
    #[Route(fullUri: '{parameter}')]
    public function invoke()
    {

    }
}
