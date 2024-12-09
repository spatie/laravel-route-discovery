<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\ResourceMethodsWithUri;

use Illuminate\Http\Request;
use Spatie\RouteDiscovery\Attributes\Route;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\User;

class ResourceMethodsWithUriController
{
    public function index()
    {
    }

    #[Route(uri: 'show/{user}')]
    public function show(User $user)
    {
    }

    #[Route(uri: 'create')]
    public function create()
    {
    }

    #[Route(uri: 'store')]
    public function store(Request $request)
    {
    }

    #[Route(uri: '{user}')]
    public function edit(User $user)
    {
    }

    #[Route(uri: 'update/{user}')]
    public function update(User $user)
    {
    }

    #[Route(uri: 'delete/{user}')]
    public function delete(User $user)
    {
    }

    #[Route(uri: 'destroy/{user}')]
    public function destroy(User $user)
    {
    }
}
