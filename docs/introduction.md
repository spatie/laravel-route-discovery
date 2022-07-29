---
title: Introduction
weight: 1
---

This package can automatically discover routes for controllers and views in your Laravel application. This isn't an all-in approach. While using auto discovery, you can still register routes like you're used to.

```php
// typically in a routes file

Discover::controllers()->in($whateverDirectoryYouPrefer);
Discover::views()->in($whateverDirectoryYouPrefer);

// other routes
```

Using PHP attributes you can manipulate discovered routes: you can set a route name, add some middleware, or ... 

Here's how you would add middleware to a controller whose route will be auto discovered.

```php
namespace App\Http\Controllers;

use Illuminate\Routing\Middleware\ValidateSignature;
use Spatie\RouteDiscovery\Attributes\Route;

class MyController
{
    #[Route(middleware: ValidateSignature::class)]
    public function myMethod() { /* ... */ }
}
```

## A note on performance

Discovering routes during each application request may have a small impact on performance. For increased performance, we highly recommend [caching your routes](https://laravel.com/docs/8.x/routing#route-caching) as part of your deployment process.
