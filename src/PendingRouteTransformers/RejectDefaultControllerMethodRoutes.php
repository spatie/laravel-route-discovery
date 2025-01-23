<?php

namespace Spatie\RouteDiscovery\PendingRouteTransformers;

use App\Http\Controllers\Controller as DefaultAppController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Spatie\RouteDiscovery\PendingRoutes\PendingRoute;
use Spatie\RouteDiscovery\PendingRoutes\PendingRouteAction;
use Spatie\RouteDiscovery\Tests\Support\TestClasses\Controllers\DefaultController\ControllerWithDefaultLaravelTraits;

class RejectDefaultControllerMethodRoutes implements PendingRouteTransformer
{
    /**
     * @var array<int, string>
     */
    public array $rejectMethodsInClasses = [
        ControllerWithDefaultLaravelTraits::class,
        DefaultAppController::class,
        Controller::class,
    ];

    /**
     * @param Collection<int, PendingRoute> $pendingRoutes
     *
     * @return Collection<int, PendingRoute>
     */
    public function transform(Collection $pendingRoutes): Collection
    {
        return $pendingRoutes->each(function (PendingRoute $pendingRoute) {
            $pendingRoute->actions = $pendingRoute
                ->actions
                ->reject(function (PendingRouteAction $pendingRouteAction) {
                    if ($pendingRouteAction->method->name == "middleware" && is_subclass_of($pendingRouteAction->method->class, "Illuminate\\Routing\\Controllers\\HasMiddleware")) {
                        return true;
                    }

                    return in_array(
                        $pendingRouteAction->method->class,
                        $this->rejectMethodsInClasses
                    );
                });
        });
    }
}
