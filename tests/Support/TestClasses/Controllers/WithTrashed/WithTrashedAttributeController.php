<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\WithTrashed;

use Illuminate\Foundation\Auth\User;
use Spatie\RouteDiscovery\Attributes\Route;

#[Route(withTrashed: true)]
class WithTrashedAttributeController
{
    #[Route(withTrashed: false)]
    public function show(User $user)
    {
    }

    public function restore(User $user)
    {
    }
}
