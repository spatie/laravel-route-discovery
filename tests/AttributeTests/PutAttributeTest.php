<?php

use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\PutTestController;

it('can register a put route', function () {
    $this->oldRouteRegistrar->registerClass(PutTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(PutTestController::class, 'myPutMethod', 'put', 'my-put-method');
});
