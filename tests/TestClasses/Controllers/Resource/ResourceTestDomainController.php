<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Resource;

use Spatie\RouteDiscovery\Attributes\Domain;
use Spatie\RouteDiscovery\Attributes\Resource;

#[Domain('my-subdomain.localhost')]
#[Resource('posts', only: ['index', 'show'])]
class ResourceTestDomainController
{
    public function index()
    {
    }

    public function show($id)
    {
    }
}
