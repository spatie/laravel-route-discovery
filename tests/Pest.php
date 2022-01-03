<?php

use Spatie\RouteDiscovery\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function controllersPath(string $directoryName): string
{
    return test()->getTestPath("TestClasses/Controllers/{$directoryName}");
}
