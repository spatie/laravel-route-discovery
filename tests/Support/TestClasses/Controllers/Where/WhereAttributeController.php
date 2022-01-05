<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Where;

use Illuminate\Foundation\Auth\User;
use Spatie\RouteDiscovery\Attributes\WhereUuid;

class WhereAttributeController
{
    #[WhereUuid('user')]
    public function edit(User $user)
    {

    }
}
