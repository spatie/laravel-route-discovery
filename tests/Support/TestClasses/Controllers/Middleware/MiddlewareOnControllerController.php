<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Middleware;

use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Middleware\TestMiddleware;

#[Route(middleware: TestMiddleware::class)]
class MiddlewareOnControllerController
{
    public function oneMiddleware()
    {
    }

    #[Route(middleware: OtherTestMiddleware::class)]
    public function twoMiddleware()
    {
    }
}
