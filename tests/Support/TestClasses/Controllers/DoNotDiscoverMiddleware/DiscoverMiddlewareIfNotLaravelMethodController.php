<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DoNotDiscoverMiddleware;

class DiscoverMiddlewareIfNotLaravelMethodController
{
    public static function middleware(): array
    {
        return [];
    }

    public function method()
    {
    }
}
