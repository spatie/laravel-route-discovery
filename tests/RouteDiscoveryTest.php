<?php

use Illuminate\Routing\Route;
use Spatie\RouteDiscovery\Attributes\WhereUuid;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\CustomRouteName\CustomRouteNameController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DefaultRouteName\DefaultRouteNameController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DefaultRouteName\Nested\AnotherDefaultRouteNameController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Domain\DomainController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DoNotDiscoverController\DoNotDiscoverThisMethodController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DoNotDiscoverMethod\DoNotDiscoverMethodController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Invokable\InvokableController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Middleware\MiddlewareOnControllerController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Middleware\MiddlewareOnMethodController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Model\ModelController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\NestedWithParametersController\Photos\CommentsController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\NestedWithParametersController\PhotosController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Nesting\Nested\ChildController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Nesting\Nested\Deepest\IndexController as DeepestIndexController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Nesting\Nested\IndexController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Nesting\ParentController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\NonPublicMethods\NonPublicMethodsController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\OverrideFullUri\OverrideFullUriController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\OverrideHttpMethod\OverrideHttpMethodController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\OverrideUri\OverrideUriController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\ResourceMethods\ResourceMethodsController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Single\MyController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Where\WhereAttributeController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Middleware\TestMiddleware;

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
        ->registerDirectory(controllersPath('CustomRouteName'));
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

    $this->assertRegisteredRoutesCount(4);

    /*
    $this->assertRouteRegistered(
        ParentController::class,
        controllerMethod: 'index',
        uri: 'parent',
    );

    $this->assertRouteRegistered(
        IndexController::class,
        controllerMethod: 'index',
        uri: 'nested',
    );

    $this->assertRouteRegistered(
        ChildController::class,
        controllerMethod: 'index',
        uri: 'nested/child',
    );
    */

    $this->assertRouteRegistered(
        DeepestIndexController::class,
        controllerMethod: '__invoke',
        uri: 'nested/deepest',
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

it('can add middleware to an entire controller and a single method', function () {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('Middleware'));

    $this
        ->assertRegisteredRoutesCount(4)
        ->assertRouteRegistered(
            MiddlewareOnControllerController::class,
            controllerMethod: 'oneMiddleware',
            middleware: [TestMiddleware::class],
        )
        ->assertRouteRegistered(
            MiddlewareOnControllerController::class,
            controllerMethod: 'twoMiddleware',
            middleware: [TestMiddleware::class, OtherTestMiddleware::class],
        )
        ->assertRouteRegistered(
            MiddlewareOnMethodController::class,
            controllerMethod: 'extraMiddleware',
            middleware: [TestMiddleware::class],
        )
        ->assertRouteRegistered(
            MiddlewareOnMethodController::class,
            controllerMethod: 'noExtraMiddleware',
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

it('will add default route names if none is set', function () {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('DefaultRouteName'));

    $this
        ->assertRegisteredRoutesCount(5)
        ->assertRouteRegistered(
            DefaultRouteNameController::class,
            controllerMethod: 'method',
            name: 'default-route-name.method',
        )
        ->assertRouteRegistered(
            DefaultRouteNameController::class,
            controllerMethod: 'edit',
            name: 'default-route-name.edit',
        )
        ->assertRouteRegistered(
            DefaultRouteNameController::class,
            controllerMethod: 'specialMethod',
            name: 'special-name',
        )
        ->assertRouteRegistered(
            AnotherDefaultRouteNameController::class,
            controllerMethod: 'method',
            name: 'nested.another-default-route-name.method',
        )
        ->assertRouteRegistered(
            AnotherDefaultRouteNameController::class,
            controllerMethod: 'edit',
            name: 'nested.another-default-route-name.edit',
        );
});

it('can handle a where attribute', function () {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('Where'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            WhereAttributeController::class,
            controllerMethod: 'edit',
            wheres: ['user' => (new WhereUuid(''))->constraint],
        );
});

it('can handle a domain attribute', function () {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('Domain'));

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(
            DomainController::class,
            controllerMethod: 'method',
            domain: 'first.example.com',
        )
        ->assertRouteRegistered(
            DomainController::class,
            controllerMethod: 'anotherMethod',
            domain: 'second.example.com',
        );
});

it('can register an invokable controller', function () {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('Invokable'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            InvokableController::class,
            uri: 'invokable',
            controllerMethod: '__invoke',
        );
});

it('will make sure the routes whose uri start with parameters will be registered last', function() {
    $this
        ->routeRegistrar
        ->registerDirectory(controllersPath('RouteOrder'));

    $this->assertRegisteredRoutesCount(3);

    $registeredUris = collect(app()->router->getRoutes())
        ->map(fn(Route $route) => $route->uri)
        ->toArray();

    expect($registeredUris)->toEqual([
        'z-z-z',
        '{parameter}/extra',
        '{parameter}',
    ]);
});
