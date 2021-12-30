<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Resource;

use Spatie\RouteDiscovery\Attributes\Resource;

#[Resource('posts', only: ['index', 'show'], names: ['index' => 'posts.list', 'show' => 'posts.view'])]
class ResourceTestNamesArrayController
{
    public function index()
    {
    }

    public function show($id)
    {
    }
}
