<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DoNotDiscoverMiddleware;

use Illuminate\Routing\Controllers\HasMiddleware;

class DoNotDiscoverMiddlewareController implements HasMiddleware
{
    public static function middleware(): array
    {
        return [];
    }

    public function method()
    {
    }
}
