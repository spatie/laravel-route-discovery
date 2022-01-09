<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\RouteOrder;

use Spatie\RouteDiscovery\Attributes\Route;

class MiddleController
{
    #[Route(fullUri: '{parameter}/extra')]
    public function invoke()
    {
    }
}
