<?php

namespace Astrid\Providers;

use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
use Symfony\Contracts\Cache\ItemInterface;

class RouteProvider extends BaseProvider
{
    public function __construct(private readonly PhpArrayAdapter $cache)
    {
    }

    public function provide(): array
    {
        return $this->cache->get('routes', function (ItemInterface $item) {
            $route_collection = include __DIR__.'/../../src/routes.php';

            $compiled_routes = (new CompiledUrlMatcherDumper($route_collection))->getCompiledRoutes();

            $item->set($compiled_routes);

            return $compiled_routes;
        });
    }
}