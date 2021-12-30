<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteDiscovery\Attributes\Route;

class InvokableRouteGetTestController
{
    #[Route('get', 'my-invokable-route')]
    public function __invoke()
    {
    }
}
