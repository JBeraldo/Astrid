<?php

require_once __DIR__.'/../vendor/autoload.php';

use Astrid\Listeners\StringResponseListener;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;

$container = include __DIR__.'/../src/container.php';

$request = Request::createFromGlobals();

$container->register('listener.string_response', StringResponseListener::class);
$container->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', [new Reference('listener.string_response')])
;
$response = $container->get('kernel')->handle($request);

$response->send();