---
title: Getting started
weight: 1
---

This package can automatically discover and register routes for a directory containing controllers.

## Via the routes file

You can enable route discovery via the routes file.

```php
// in a routes file

use Spatie\RouteDiscovery\Discovery\Discover;

Discover::controllers()->in(app_path('Http/Controllers'));
```

## Via the config file

Alternatively, you can discover routes using the config file.

First, you need to publish the config file. This will create a file at `config/route-discovery.php`

```bash
php artisan vendor:publish --tag="route-discovery-config"
```

In the `discover_controllers_in_directory` key of the `route-discovery` config file, you can specify a directory that contains controllers.

Here you can uncomment the line to register controllers in the `app_path('Http/Controllers')` directory. Of course you can use any directory you want.

```php
// config/route-discovery

/*
 * Routes will be registered for all controllers found in
 * these directories.
 */
'discover_controllers_in_directory' => [
    app_path('Http/Controllers'),
],
// ...
```






