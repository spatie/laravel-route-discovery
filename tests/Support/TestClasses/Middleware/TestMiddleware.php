<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Middleware;

use Closure;
use Illuminate\Http\Request;

class TestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
