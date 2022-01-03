<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Discovery\Single;

class MyController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
