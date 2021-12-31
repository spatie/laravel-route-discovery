<?php

namespace Spatie\RouteDiscovery\Discovery;

use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use SplFileInfo;

class NodeFactory
{
    public function __construct(
        public string $basePath,
        protected string $rootNamespace,
        protected string $registeringDirectory
    )
    {
    }

    public function make(SplFileInfo $fileInfo): ?Node
    {
        $fullyQualifiedClassName = $this->fullQualifiedClassNameFromFile($fileInfo);

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
                return new Action($method, $fullyQualifiedClassName);
            });

        $uri = $this->discoverUri($class);


        return new Node($fileInfo, $uri, $fullyQualifiedClassName, $actions, collect());
    }

    protected function discoverUri(ReflectionClass $class): ?string
    {
        $lastPart = Str::of($class->getFileName())
            ->after($this->registeringDirectory)
            ->beforeLast('Controller')
            ->explode('/')
            ->last();

        return Str::of($lastPart)->kebab();
    }

    protected function fullQualifiedClassNameFromFile(SplFileInfo $file): string
    {
        $class = trim(Str::replaceFirst($this->basePath, '', $file->getRealPath()), DIRECTORY_SEPARATOR);

        $class = str_replace(
            [DIRECTORY_SEPARATOR, 'App\\'],
            ['\\', app()->getNamespace()],
            ucfirst(Str::replaceLast('.php', '', $class))
        );

        return $this->rootNamespace . $class;
    }
}
