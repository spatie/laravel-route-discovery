<?php

use Illuminate\Routing\ViewController;
use Spatie\RouteDiscovery\Discovery\Discover;

it('can discover controllers in a directory', function () {
    config()->set('route-discovery.discover_controllers_in_directory', [
        controllersPath('Single'),
    ]);

    $this->registerControllersFromConfigFile();

    expect(true)->toBeTrue();
});

it('can discover a single directory with a prefix', function () {
    config()->set('route-discovery.discover_views_in_directory', [
        'docs' => $this->getTestPath('Support/TestClasses/resources/views'),
    ]);

    $this->registerViewsFromConfigFile();

    $this->assertRouteRegistered(
        ViewController::class,
        controllerMethod: '\\' . ViewController::class,
        uri: 'docs/contact',
    );
});

it('can discover a single directory without a prefix', function () {
    config()->set('route-discovery.discover_views_in_directory', [
        $this->getTestPath('Support/TestClasses/resources/views'),
    ]);

    $this->registerViewsFromConfigFile();

    $this->assertRouteRegistered(
        ViewController::class,
        controllerMethod: '\\' . ViewController::class,
        uri: 'contact',
    );
});

it('can use custom default route names', function () {
    config()->set('route-discovery.default_route_names', [
        'myCustomMethod' => 'renamed-custom-method',
    ]);

    Discover::controllers()
        ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in(controllersPath('CustomMethod'));

    $this
        ->assertRouteRegistered(
            controller: \Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\CustomMethod\CustomMethodController::class,
            controllerMethod: 'myCustomMethod',
            uri: 'custom-method/my-custom-method',
            name: 'custom-method.renamed-custom-method'
        );
});
