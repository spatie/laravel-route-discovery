<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\OptionalParameter;

use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\Photo;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Models\User;

class OptionalParameterController
{
    /**
     * Test method with optional parameter
     */
    public function optional(?User $user = null)
    {
    }

    /**
     * Test method with multiple optional parameters
     */
    public function multiple(?User $user = null, ?Photo $photo = null)
    {
    }

    /**
     * Test method with mixed required and optional parameters
     */
    public function mixed(User $user, ?Photo $photo = null)
    {
    }
}
