<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Resource;

use Spatie\RouteDiscovery\Attributes\Resource;

#[Resource('posts', only: ['index', 'show'], names: 'api.v1.posts')]
class ResourceTestNamesStringController
{
    public function index()
    {
    }

    public function show($id)
    {
    }
}
