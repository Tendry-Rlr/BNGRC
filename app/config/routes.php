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
use app\controllers\ReinitController;


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
    // $router->post('/donner', [$don, 'donner']);
    $router->post('/petitDon', [$don, 'petitDons']);

    $ville = new VilleController();
    $router->get('/villes' , [$ville, 'listeVille']);
    $router->get('/ville/@id' , [$ville, 'listeVilleByRegion']);
    $router->get('/besoinville/@id', [$ville , 'listeBesoinByVille']);

    $besoin = new BesoinController();
    $router->get('/besoinville/@id', [$besoin , 'listeBesoinByVille']);
    $router->get('/addbesoin', [$besoin, 'loadInsert']);
    $router->post('/insertBesoin', [$besoin, 'insertBesoin']);
    $router->post('/besoinproche', [$besoin, 'besoinProche']);

    $simulation = new SimulationController();
    $router->get('/simulation', [$simulation, 'getSimulation']);
    $router->post('/simuler', [$simulation, 'simulation']);
    $router->post('/valider', [$simulation, 'validation']);
    $router->post('/annuler', [$simulation, 'annuler']);

    $achat = new AchatController();
    $router->get('/achat/@id/', [$achat, 'redirectAchat']);
    $router->post('/insertAchat', [$achat, 'insertAchat']);
    $router->get('/listeAchat', [$achat, 'listeAchat']);
    $router->post('/filtreAchat', [$achat, 'filtrerAchat']);

    $recapitulation = new RecapitulationController();
    $router->get('/recapitulation', [$recapitulation, 'recapitulation']);
    $router->get('/api/recapitulation', [$recapitulation, 'recapitulationApi']);

    $router->post('/donProp', [$don, 'proportionnelle']);

    $reinit = new ReinitController();
    $router->get('/reinitialize', [$reinit, 'reinit']);

}, [SecurityHeadersMiddleware::class]);
