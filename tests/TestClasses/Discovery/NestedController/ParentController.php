<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Discovery\NestedController;

class ParentController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
