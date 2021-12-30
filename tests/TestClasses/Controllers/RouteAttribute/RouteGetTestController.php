<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteDiscovery\Attributes\Route;

class RouteGetTestController
{
    #[Route('get', 'my-get-method')]
    public function myGetMethod()
    {
    }
}
