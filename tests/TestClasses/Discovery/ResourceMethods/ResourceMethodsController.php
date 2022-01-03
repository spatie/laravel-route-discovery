<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Discovery\ResourceMethods;

use Illuminate\Http\Request;
use Spatie\RouteDiscovery\Tests\TestClasses\Models\User;

class ResourceMethodsController
{
    public function index()
    {
    }

    public function show(User $user)
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function edit(User $user)
    {
    }

    public function update(User $user)
    {
    }

    public function destroy(User $user)
    {
    }
}
