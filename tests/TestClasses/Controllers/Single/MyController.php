<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Single;

class MyController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
