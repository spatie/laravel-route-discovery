<?php

use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\MiddlewareOnMethod\MiddlewareOnMethodController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\Model\ModelController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\NestedWithParametersController\Photos\CommentsController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\NestedWithParametersController\PhotosController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\Nesting\Nested\ChildController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\Nesting\ParentController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\NonPublicMethods\NonPublicMethodsController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\OverrideHttpMethod\OverrideHttpMethodController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\ResourceMethods\ResourceMethodsController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\RouteName\CustomRouteNameController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\Single\MyController;
use Spatie\RouteDiscovery\Tests\TestClasses\Middleware\TestMiddleware;

it('can automatically discovery a simple route', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/Single'));

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
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/Nesting'));

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
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/Model'));

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
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/NonPublicMethods'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            NonPublicMethodsController::class,
            controllerMethod: 'index',
            uri: 'non-public-methods',
        );
});

it('will register routes with the correct http verbs for resourceful methods', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/ResourceMethods'));

    $this
        ->assertRegisteredRoutesCount(7)
        ->assertRouteRegistered(
            ResourceMethodsController::class,
            controllerMethod: 'index',
            uri: 'resource-methods',
            httpMethods: ['get'],
        )
        ->assertRouteRegistered(
            ResourceMethodsController::class,
            controllerMethod: 'show',
            uri: 'resource-methods/{user}',
            httpMethods: ['get'],
        )
        ->assertRouteRegistered(
            ResourceMethodsController::class,
            controllerMethod: 'create',
            uri: 'resource-methods/create',
            httpMethods: ['get'],
        )
        ->assertRouteRegistered(
            ResourceMethodsController::class,
            controllerMethod: 'store',
            uri: 'resource-methods',
            httpMethods: ['post'],
        )
        ->assertRouteRegistered(
            ResourceMethodsController::class,
            controllerMethod: 'edit',
            uri: 'resource-methods/edit/{user}',
            httpMethods: ['get'],
        )
        ->assertRouteRegistered(
            ResourceMethodsController::class,
            controllerMethod: 'update',
            uri: 'resource-methods/{user}',
            httpMethods: ['put', 'patch'],
        )
        ->assertRouteRegistered(
            ResourceMethodsController::class,
            controllerMethod: 'destroy',
            uri: 'resource-methods/{user}',
            httpMethods: ['delete'],
        );
});

it('can override the http method', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/OverrideHttpMethod'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            OverrideHttpMethodController::class,
            controllerMethod: 'edit',
            uri: 'override-http-method/edit/{user}',
            httpMethods: ['delete'],
        );
});

it('can add middleware to a method', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Discovery/MiddlewareOnMethod'));

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(
            MiddlewareOnMethodController::class,
            controllerMethod: 'extraMiddleware',
            uri: 'middleware-on-method/extra-middleware',
            middleware: [TestMiddleware::class],
        )
        ->assertRouteRegistered(
            MiddlewareOnMethodController::class,
            controllerMethod: 'noExtraMiddleware',
            uri: 'middleware-on-method/no-extra-middleware',
            middleware: [],
        );
});
