<?php

use Illuminate\Support\Facades\Route;
use Spatie\RouteDiscovery\Discovery\Discover;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\CustomMethod\CustomMethodController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DefaultController\ControllerThatExtendsDefaultController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\Single\MyController;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\UsesUnionTypes\UnionController;

it('can discover controller in a directory', function () {
    Discover::controllers()
        ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in(controllersPath('Single'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            MyController::class,
            controllerMethod: 'index',
            uri: 'my',
        );
});

it('does not discover routes for default Laravel skeleton controllers that have public methods', function () {
    Discover::controllers()
        ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in(controllersPath('DefaultController'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            ControllerThatExtendsDefaultController::class,
            controllerMethod: 'index',
            uri: 'controller-that-extends-default',
        );
});

it('can discover controllers with custom methods', function () {
    Discover::controllers()
        ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in(controllersPath('CustomMethod'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            CustomMethodController::class,
            controllerMethod: 'myCustomMethod',
            uri: 'custom-method/my-custom-method'
        );
});

it('can use a prefix when discovering routes', function () {
    Route::prefix('my-prefix')->group(function () {
        Discover::controllers()
            ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
            ->useBasePath(test()->getTestPath())
            ->in(controllersPath('Single'));
    });

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            MyController::class,
            controllerMethod: 'index',
            uri: 'my-prefix/my',
        );
});

it('can handle a union parameter', function () {
    Discover::controllers()
        ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in(controllersPath('UsesUnionTypes'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            UnionController::class,
            controllerMethod: 'example',
            uri: 'union/example',
        );
});
