<?php

use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\DomainTestController;

it('can apply a domain on the url of every method', function () {
    $this->oldRouteRegistrar->registerClass(DomainTestController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(
            DomainTestController::class,
            controllerMethod: 'myGetMethod',
            uri: 'my-get-method',
            domain: 'my-subdomain.localhost'
        )
        ->assertRouteRegistered(
            DomainTestController::class,
            controllerMethod: 'myPostMethod',
            httpMethods: 'post',
            uri: 'my-post-method',
            domain: 'my-subdomain.localhost'
        );
});
