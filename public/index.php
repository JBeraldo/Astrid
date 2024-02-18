<?php

require_once __DIR__.'/../vendor/autoload.php';

use Astrid\Listeners\StringResponseListener;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;

$routes = include __DIR__.'/../src/routes.php';
$container = include __DIR__.'/../src/container.php';

$request = Request::createFromGlobals();

$container->register('listener.string_response', StringResponseListener::class);
$container->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')])
;
$compiledRoutes = (new CompiledUrlMatcherDumper($routes))->getCompiledRoutes();
$container->setParameter('routes', $compiledRoutes);

$response = $container->get('kernel')->handle($request);

$response->send();