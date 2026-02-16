<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

use app\controllers\RegionController;
use app\controllers\DonController;


/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

    $region = new RegionController();
    $router->get('/', [$region, 'listeRegion']);

    $don = new DonController();
    $router->get('/don', [$don, 'listeDon']);
    $router->post('/donner', [$don, 'donner']);
    
}, [SecurityHeadersMiddleware::class]);
