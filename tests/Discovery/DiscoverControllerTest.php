<?php

use Illuminate\Support\Facades\Route;
use Spatie\RouteDiscovery\Discovery\Discover;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\CustomMethod\CustomMethodController;
use Spatie\RouteDiscovery\Tests\TestClasses\Discovery\SingleController\MyController;

it('can discover controller in a directory', function () {
    Discover::controllers()
        ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in($this->getTestPath('TestClasses/Discovery/SingleController'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            MyController::class,
            controllerMethod: 'index',
            uri: 'my',
        );
});

it('can discover controllers with custom methods', function () {
    Discover::controllers()
        ->useRootNamespace('Spatie\RouteDiscovery\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in($this->getTestPath('TestClasses/Discovery/CustomMethod'));

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
            ->in(test()->getTestPath('TestClasses/Discovery/SingleController'));
    });

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            MyController::class,
            controllerMethod: 'index',
            uri: 'my-prefix/my',
        );
});
