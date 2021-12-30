<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Resource;

use Spatie\RouteDiscovery\Attributes\Prefix;
use Spatie\RouteDiscovery\Attributes\Resource;

#[Prefix('/api/v1/my-prefix/etc')]
#[Resource('posts', only: ['index', 'show'])]
class ResourceTestPrefixController
{
    public function index()
    {
    }

    public function show($id)
    {
    }
}
