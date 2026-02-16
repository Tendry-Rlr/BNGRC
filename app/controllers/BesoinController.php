<?php

namespace app\controllers;

use app\models\BesoinModel;
use Flight;

class BesoinController
{
    public function listeBesoin()
    {
        $besoin = new BesoinModel(Flight::db());
        $liste = $besoin->getAllBesoin();
        Flight::render('index', [
            'listeBesoin' => $liste,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }
}