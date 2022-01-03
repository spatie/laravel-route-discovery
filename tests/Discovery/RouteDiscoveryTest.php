<?php

use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\DoNotDiscoverController\DoNotDiscoverThisMethodController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\DoNotDiscoverMethod\DoNotDiscoverMethodController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\MiddlewareOnMethod\MiddlewareOnMethodController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Model\ModelController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\NestedWithParametersController\Photos\CommentsController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\NestedWithParametersController\PhotosController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Nesting\Nested\ChildController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Nesting\ParentController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\NonPublicMethods\NonPublicMethodsController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\OverrideFullUri\OverrideFullUriController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\OverrideHttpMethod\OverrideHttpMethodController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\OverrideUri\OverrideUriController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\ResourceMethods\ResourceMethodsController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\RouteName\CustomRouteNameController;
use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\Single\MyController;
use Spatie\RouteDiscovery\Tests\TestClasses\Middleware\TestMiddleware;

it('can automatically discovery a simple route', function () {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('Single'));

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
        ->registerDirectory(controllersPath('RouteName'));
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
        ->registerDirectory(controllersPath('Nesting'));

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
        ->registerDirectory(controllersPath('NestedWithParametersController'));

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
        ->registerDirectory(controllersPath('Model'));

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
        ->registerDirectory(controllersPath('NonPublicMethods'));

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
        ->registerDirectory(controllersPath('ResourceMethods'));

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
        ->registerDirectory(controllersPath('OverrideHttpMethod'));

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
        ->registerDirectory(controllersPath('MiddlewareOnMethod'));

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

it('can override the uri', function () {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('OverrideUri'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            OverrideUriController::class,
            controllerMethod: 'myMethod',
            uri: 'override-uri/alternative-uri',
        );
});

it('can override the full uri', function () {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('OverrideFullUri'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            OverrideFullUriController::class,
            controllerMethod: 'myMethod',
            uri: 'alternative-uri',
        );
});

it('can avoid discovering a method', function () {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('DoNotDiscoverMethod'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            DoNotDiscoverMethodController::class,
            controllerMethod: 'method',
            uri: 'do-not-discover-method/method',
        );
});

it('can avoid discovering a controller', function () {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('DoNotDiscoverController'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            DoNotDiscoverThisMethodController::class,
            controllerMethod: 'method',
            uri: 'do-not-discover-this-method/method',
        );
});

