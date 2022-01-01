---
title: Introduction
weight: 1
---

## THIS PACKAGE IS IN DEVELOPMENT, DON'T USE IT YET

This package can automatically discover routes for controllers and views in your Laravel application.

You can specify which controller and view directories need to be automatically registered, and you can still use a regular routes file in combination with route discovery. Using PHP attributes you can manipulate discover routes: you can set a route name, add some middleware, or ...

Because the internals of this package heavily use PHP reflection, there is a small performance hit, which locally in most cases isn't notable. In a production environment, we highly recommend [caching your routes](https://laravel.com/docs/8.x/routing#route-caching). 

