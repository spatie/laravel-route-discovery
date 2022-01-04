<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Middleware;

use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Middleware\TestMiddleware;

class MiddlewareOnMethodController
{
    #[Route(middleware: TestMiddleware::class)]
    public function extraMiddleware()
    {
    }

    public function noExtraMiddleware()
    {
    }
}
