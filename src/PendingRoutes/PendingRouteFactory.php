<?php

namespace Spatie\RouteDiscovery\PendingRoutes;

use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use SplFileInfo;

class PendingRouteFactory
{
    public function __construct(
        public string $basePath,
        protected string $rootNamespace,
        protected string $registeringDirectory
    ) {
    }

    public function make(SplFileInfo $fileInfo): ?PendingRoute
    {
        $fullyQualifiedClassName = $this->fullyQualifiedClassNameFromFile($fileInfo);

        if (! class_exists($fullyQualifiedClassName)) {
            return null;
        }

        $class = new ReflectionClass($fullyQualifiedClassName);

        if ($class->isAbstract()) {
            return null;
        }

        $actions = collect($class->getMethods())
            ->filter(function (ReflectionMethod $method) {
                return $method->isPublic();
            })
            ->map(function (ReflectionMethod $method) use ($fullyQualifiedClassName) {
                return new PendingRouteAction($method, $fullyQualifiedClassName);
            });

        $uri = $this->discoverUri($class);

        return new PendingRoute($fileInfo, $class, $uri, $fullyQualifiedClassName, $actions);
    }

    protected function discoverUri(ReflectionClass $class): string
    {
        $parts = Str::of((string) $class->getFileName())
            ->after(str_replace('/', DIRECTORY_SEPARATOR, $this->registeringDirectory))
            ->beforeLast('Controller')
            ->explode(DIRECTORY_SEPARATOR);

        return collect($parts)
            ->filter()
            ->reject(function (string $part) {
                return strtolower($part) === 'index';
            })
            ->map(fn (string $part) => Str::of($part)->kebab())
            ->implode('/');
    }

    protected function fullyQualifiedClassNameFromFile(SplFileInfo $file): string
    {
        $class = trim(Str::replaceFirst($this->basePath, '', (string)$file->getRealPath()), DIRECTORY_SEPARATOR);

        $class = $this->customControllers($class);

        $class = str_replace(
            [DIRECTORY_SEPARATOR, 'App\\'],
            ['\\', app()->getNamespace()],
            ucfirst(Str::replaceLast('.php', '', $class))
        );

        return $this->rootNamespace . $class;
    }

    private function customControllers(string $class): string
    {
        // TODO: do some improvements here
        $array = [
            'packages'.DIRECTORY_SEPARATOR.'workbench'.DIRECTORY_SEPARATOR.'pbkip' => 'Workbench\Pbkip',
            'packages'.DIRECTORY_SEPARATOR.'workbench'.DIRECTORY_SEPARATOR.'pbm' => 'Workbench\Pbm',
            'packages'.DIRECTORY_SEPARATOR.'workbench'.DIRECTORY_SEPARATOR.'pbpbb' => 'Workbench\Pbpbb',
        ];

        foreach ($array as $key => $value) {
            if (str_contains($class, $key)) {
                $class = str_replace($key.DIRECTORY_SEPARATOR.'src', $value, $class);
            }
        }

        return $class;
    }
}
