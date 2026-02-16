<?php

namespace app\controllers;

use app\models\RegionModel;
use Flight;

class RegionController
{
    public function listeRegion()
    {
        $region = new RegionModel(Flight::db());
        $liste = $region->getAllRegion();
        Flight::render('index', [
            'listeRegion' => $liste,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }
}