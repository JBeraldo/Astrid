<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('leap_year', new Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => [\App\Controllers\LeapYearController::class,'index']
]));

return $routes;
