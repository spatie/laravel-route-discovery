<?php

namespace Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Domain;

use Spatie\RouteDiscovery\Attributes\Route;

#[Route(domain: 'first.example.com')]
class DomainController
{
    public function method()
    {

    }

    #[Route(domain: 'second.example.com')]
    public function anotherMethod()
    {

    }
}
