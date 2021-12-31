<?php

namespace Spatie\RouteDiscovery\Tests\TestClasses\Discovery\ControllerWithNonPublicMethods;

class NonPublicMethodsController
{
    public function index()
    {
    }

    protected function willNotBeDiscovered()
    {
    }

    private function anotherOneThatWillNotBeDiscovered()
    {
    }
}
