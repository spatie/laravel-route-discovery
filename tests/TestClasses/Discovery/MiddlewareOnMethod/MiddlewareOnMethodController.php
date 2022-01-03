<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Discovery\MiddlewareOnMethod;

use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Tests\TestClasses\Middleware\TestMiddleware;

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
