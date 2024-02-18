<?php

namespace Astrid\Providers;

use Astrid\Facades\RouteCache;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
use Symfony\Contracts\Cache\ItemInterface;

class RouteProvider extends BaseProvider
{
    public function __construct()
    {
    }

    public function provide(): array
    {
        return RouteCache::get();
    }
}