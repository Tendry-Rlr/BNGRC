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
        Flight::render('listeVille', [
            'listeVille' => $liste,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }
    public function listeBesoinByVille($idVille){
        $ville = new VilleModel(Flight::db());
        
    }
}