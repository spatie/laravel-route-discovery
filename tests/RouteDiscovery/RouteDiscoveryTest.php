<?php

use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\ControllerWithNonPublicMethods\NonPublicMethodsController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\ModelController\ModelController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\NestedController\Nested\ChildController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\NestedController\ParentController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\NestedWithParametersController\Photos\CommentsController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\NestedWithParametersController\PhotosController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\RouteName\CustomRouteNameController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\SingleController\MyController;

it('can automatically discovery a simple route', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/SingleController'));

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
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/RouteName'));
    $this->assertRegisteredRoutesCount(1);

    $this->assertRouteRegistered(
        CustomRouteNameController::class,
        controllerMethod: 'index',
        uri: 'custom-route-name',
        name: 'this-is-a-custom-name',
    );
});

it('can automatically discover a nested route without model parameters', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/NestedController'));

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

it('can automatically discover a nested route with model parameters', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/NestedWithParametersController'));

    $this->assertRegisteredRoutesCount(4);

    $this->assertRouteRegistered(
        PhotosController::class,
        controllerMethod: 'show',
        uri: 'photos/{photo}',
    );

    $this->assertRouteRegistered(
        PhotosController::class,
        controllerMethod: 'edit',
        uri: 'photos/edit/{photo}',
    );

    $this->assertRouteRegistered(
        CommentsController::class,
        controllerMethod: 'show',
        uri: 'photos/{photo}/comments/{comment}',
    );
    $this->assertRouteRegistered(
        CommentsController::class,
        controllerMethod: 'edit',
        uri: 'photos/{photo}/comments/edit/{comment}',
    );
});

it('can automatically discovery a model route', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/ModelController'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            ModelController::class,
            controllerMethod: 'edit',
            uri: 'model/edit/{user}',
        );
});

it('will only automatically register public methods', function () {
    $this
        ->oldRouteRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/ControllerWithNonPublicMethods'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            NonPublicMethodsController::class,
            controllerMethod: 'index',
            uri: 'non-public-methods',
        );
});
