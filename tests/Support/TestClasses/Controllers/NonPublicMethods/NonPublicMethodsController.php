<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\NonPublicMethods;

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
