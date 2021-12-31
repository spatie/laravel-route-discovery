<?php

use Spatie\RouteDiscovery\Tests\TestClasses\AutoDiscovery\ControllerWithNonPublicMethods\NonPublicMethodsController;
use Spatie\RouteDiscovery\Tests\TestClasses\AutoDiscovery\ModelController\ModelController;
use Spatie\RouteDiscovery\Tests\TestClasses\AutoDiscovery\NestedController\Nested\ChildController;
use Spatie\RouteDiscovery\Tests\TestClasses\AutoDiscovery\NestedController\ParentController;
use Spatie\RouteDiscovery\Tests\TestClasses\AutoDiscovery\RouteName\CustomRouteNameController;
use Spatie\RouteDiscovery\Tests\TestClasses\AutoDiscovery\SingleController\MyController;

it('can automatically discovery a simple route', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/AutoDiscovery/SingleController'));

    $this->assertRegisteredRoutesCount(1);

    $this->assertRouteRegistered(
        MyController::class,
        controllerMethod: 'index',
        uri: 'my',
    );
});

it('can automatically discovery a route with a custom name', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/AutoDiscovery/RouteName'));
    $this->assertRegisteredRoutesCount(1);

    $this->assertRouteRegistered(
        CustomRouteNameController::class,
        controllerMethod: 'index',
        uri: 'custom-route-name',
        name: 'this-is-a-custom-name',
    );
});

it('can automatically discover a nested route', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/AutoDiscovery/NestedController'));

    $this->assertRegisteredRoutesCount(2);

    $this->assertRouteRegistered(
        ParentController::class,
        controllerMethod: 'index',
        uri: 'parent',
    );

    $this->assertRouteRegistered(
        ChildController::class,
        controllerMethod: 'index',
        uri: 'nested/child',
    );
});

it('can automatically discovery a model route', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/AutoDiscovery/ModelController'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            ModelController::class,
            controllerMethod: 'edit',
            uri: 'model/{user}',
        );
});

it('will only automatically register public methods', function () {
    $this
        ->oldRouteRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/AutoDiscovery/ControllerWithNonPublicMethods'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            NonPublicMethodsController::class,
            controllerMethod: 'index',
            uri: 'non-public-methods',
        );
});
