<?php

use Illuminate\Routing\ViewController;

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
