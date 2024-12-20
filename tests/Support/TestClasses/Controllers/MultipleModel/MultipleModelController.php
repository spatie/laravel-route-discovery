<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\MultipleModel;

use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\Photo;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\User;

class MultipleModelController
{
    public function edit(User $user, Photo $photo)
    {
    }
}
