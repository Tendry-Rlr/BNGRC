<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

use app\controllers\RegionController;
use app\controllers\VilleController;
use app\controllers\BesoinController;


/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

    $region = new RegionController();
    $router->get('/', [$region, 'listeRegion']);

    $ville = new VilleController();
    $router->get('/ville/@id' , [$ville, 'listeVilleByRegion']);
    $router->get('/besoinville/@id', [$ville , 'listeBesoinByVille']);

}, [SecurityHeadersMiddleware::class]);
