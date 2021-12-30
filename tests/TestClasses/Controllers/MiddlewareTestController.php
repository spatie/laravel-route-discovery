<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers;

use Spatie\RouteDiscovery\Attributes\Middleware;
use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Tests\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteDiscovery\Tests\TestClasses\Middleware\TestMiddleware;

#[Middleware(TestMiddleware::class)]
class MiddlewareTestController
{
    #[Route('get', 'single-middleware')]
    public function singleMiddleware()
    {
    }

    #[Route('get', 'multiple-middleware', middleware: OtherTestMiddleware::class)]
    public function multipleMiddleware()
    {
    }
}
