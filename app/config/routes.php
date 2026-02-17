<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

use app\controllers\RegionController;
use app\controllers\DonController;
use app\controllers\VilleController;
use app\controllers\BesoinController;
use app\controllers\SimulationController;
use app\controllers\AchatController;
use app\controllers\RecapitulationController;


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
    
    $ville = new VilleController();
    $router->get('/ville/@id' , [$ville, 'listeVilleByRegion']);
    $router->get('/besoinville/@id', [$ville , 'listeBesoinByVille']);

    $besoin = new BesoinController();
    $router->get('/besoinville/@id', [$besoin , 'listeBesoinByVille']);
    $router->get('/addbesoin', [$besoin, 'loadInsert']);
    $router->post('/insertBesoin', [$besoin, 'insertBesoin']);

    $simulation = new SimulationController();
    $router->get('/simulation', [$simulation, 'getSimulation']);
    $router->post('/simuler', [$simulation, 'simulation']);
    $router->post('/valider', [$simulation, 'validation']);

    $achat = new AchatController();
    $router->get('/achat/@id/', [$achat, 'redirectAchat']);
    $router->post('/insertAchat', [$achat, 'insertAchat']);
    $router->get('/listeAchat', [$achat, 'listeAchat']);
    $router->post('/filtreAchat', [$achat, 'filtrerAchat']);

    $recapitulation = new RecapitulationController();
    $router->get('/recapitulation', [$recapitulation, 'recapitulation']);

}, [SecurityHeadersMiddleware::class]);
