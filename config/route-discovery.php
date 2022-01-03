<?php

use Spatie\RouteDiscovery\NodeTransformers\AddControllerUriToActions;
use Spatie\RouteDiscovery\NodeTransformers\FixUrisOfNestedControllers;
use Spatie\RouteDiscovery\NodeTransformers\HandleCustomHttpMethods;
use Spatie\RouteDiscovery\NodeTransformers\HandleCustomMiddleware;
use Spatie\RouteDiscovery\NodeTransformers\HandleCustomRouteName;

return [
    /*
     * Routes will be registered for all controllers found in
     * these directories.
     */
    'discover_controllers_in_directory' => [
        app_path('Http/Controllers'),
    ],

    /*
     * Routes will be registered for all views found in these directories.
     * The key of an item will be used as the prefix of the uri.
     */
    'discover_views_in_directory' => [
        // 'docs' => resource_path('views/docs'),
    ],

    /*
     * After having discovered all controllers, these classes will manipulate the routes
     * before registering them to Laravel.
     *
     * In most cases, you shouldn't change these
     */
    'node_tree_transformers' => [
        AddControllerUriToActions::class,
        HandleCustomRouteName::class,
        HandleCustomMiddleware::class,
        HandleCustomHttpMethods::class,
        FixUrisOfNestedControllers::class,
    ]
];
