<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Tests\TestClasses\Middleware\TestMiddleware;

class RouteMiddlewareTestController
{
    #[Route('get', 'my-method', middleware: TestMiddleware::class)]
    public function myMethod()
    {
    }
}
