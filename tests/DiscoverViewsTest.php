<?php

use Illuminate\Routing\ViewController;
use Spatie\RouteDiscovery\Discovery\Discover;

it('can discover views in a directory', function () {
    Discover::views()->in($this->getTestPath('Support/TestClasses/resources/views'));

    $this->assertRegisteredRoutesCount(6);

    collect([
        '/' => 'home',
        'home' => 'home',
        'long-name' => 'long-name',
        'contact' => 'contact',
        'nested' => 'nested',
        'nested/another' => 'nested.another',
    ])->each(function (string $name, string $uri) {
        $this->assertRouteRegistered(
            ViewController::class,
            controllerMethod: '\\' . ViewController::class,
            uri: $uri,
            name: $name,
        );
    });
});
