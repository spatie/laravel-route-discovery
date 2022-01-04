<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DefaultRouteName;

use Illuminate\Foundation\Auth\User;
use Spatie\RouteDiscovery\Attributes\Route;

class DefaultRouteNameController
{
    public function method()
    {

    }

    public function edit(User $user)
    {

    }

    #[Route(name: 'special-name')]
    public function specialMethod()
    {

    }
}
