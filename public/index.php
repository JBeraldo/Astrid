<?php

require_once '../vendor/autoload.php';

use App\App;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;


$request = Request::createFromGlobals();

$routes = include __DIR__.'/../src/routes.php';

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$framework = new App($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();