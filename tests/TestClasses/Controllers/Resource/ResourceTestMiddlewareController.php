<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Resource;

use Spatie\RouteDiscovery\Attributes\Middleware;
use Spatie\RouteDiscovery\Attributes\Resource;
use Spatie\RouteDiscovery\Tests\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteDiscovery\Tests\TestClasses\Middleware\TestMiddleware;

#[Middleware([TestMiddleware::class, OtherTestMiddleware::class])]
#[Resource('posts', only: ['index', 'show'])]
class ResourceTestMiddlewareController
{
    public function index()
    {
    }

    public function show($id)
    {
    }
}
