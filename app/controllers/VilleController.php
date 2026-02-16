<?php

namespace app\controllers;

use app\models\VilleModel;
use Flight;

class VilleController
{
    public function listeVilleByRegion($idVille)
    {
        $ville = new VilleModel(Flight::db());
        $liste = $ville->getVillesByRegion($idVille);
        Flight::render('villes', [
            'listeVille' => $liste,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);

    }
}