---
title: Introduction
weight: 1
---

**THIS PACKAGE IS IN DEVELOPMENT, DON'T USE IT (FOR NOW)**

This package can automatically discover routes for controllers and views in your Laravel application.

You can specify which controller and view directories need to be automatically registered, and you can still use a regular routes file in combination with route discovery. Using PHP attributes you can manipulate discover routes: you can set a route name, add some middleware, or ...

Discovering routes during each application request may have a small negative impact on performance. For increased performance, we highly recommend [caching your routes](https://laravel.com/docs/8.x/routing#route-caching) as part of your deployment process.
