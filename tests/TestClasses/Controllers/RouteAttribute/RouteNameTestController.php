<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteDiscovery\Attributes\Route;

class RouteNameTestController
{
    #[Route('get', 'my-method', name: 'test-name')]
    public function myMethod()
    {
    }
}
