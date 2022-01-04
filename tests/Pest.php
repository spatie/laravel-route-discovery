<?php

use Spatie\RouteDiscovery\Tests\Support\TestCase;

uses(TestCase::class)->in(__DIR__);

function controllersPath(string $directoryName): string
{
    return realpath(test()->getTestPath("Support/TestClasses/Controllers/{$directoryName}"));
}
