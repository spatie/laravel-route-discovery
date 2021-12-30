<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Resource;

use Illuminate\Http\Request;
use Spatie\RouteDiscovery\Attributes\Resource;

#[Resource('posts', except: ['update', 'destroy'])]
class ResourceTestExceptController
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }
}
