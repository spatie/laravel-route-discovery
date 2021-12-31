<?php

use Spatie\RouteDiscovery\Tests\TestClasses\Controllers\PostTestController;

it('can register a post route', function () {
    $this->oldRouteRegistrar->registerClass(PostTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(PostTestController::class, 'myPostMethod', 'post', 'my-post-method');
});
