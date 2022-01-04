<?php

namespace Spatie\RouteDiscovery\Discovery;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class DiscoverViews
{
    public function in(string $directory): void
    {
        $files = (new Finder())->files()->name('*.blade.php')->in($directory);

        collect($files)->each(function (SplFileInfo $file) use ($directory) {
            $this->registerRouteForView($file, $directory);
        });
    }

    protected function registerRouteForView(SplFileInfo $file, string $baseDirectory): void
    {
        $uri = Str::of($file->getPathname())
            ->after($baseDirectory)
            ->beforeLast('.blade.php');

        $view = $uri->replace(DIRECTORY_SEPARATOR, '.');

        $uri = Str::replaceLast(DIRECTORY_SEPARATOR . 'index', DIRECTORY_SEPARATOR, (string)$uri);

        $uri = collect(explode(DIRECTORY_SEPARATOR, $uri))
            ->map(function (string $uriSegment) {
                return Str::kebab($uriSegment);
            })
            ->join('/');

        Route::view($uri, $view);
    }
}
