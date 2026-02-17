<?php

namespace app\controllers;

use app\models\VilleModel;
use app\models\BesoinModel;
use app\models\DonModel;
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
    public function listeBesoinByVille($idVille)
    {
        $ville = new VilleModel(Flight::db());
        $besoin = new BesoinModel(Flight::db());
        $don = new DonModel(Flight::db());
        $details = $ville->getVilleById($idVille);
        $liste = $besoin->getBesoinByVille($idVille);
        $listedon = $don->getDonByVille($idVille);
        Flight::render('listeBesoinVille', [
            'listeBesoin' => $liste,
            'baseUrl' => Flight::get('flight.base_url'),
            'details' => $details,
            'listeDon' => $listedon,
        ]);
    }

    public function listeVille()
    {
        $ville = new VilleModel(Flight::db());
        $liste = $ville->getAllVille();
        Flight::render('villes', [
            'listeVille' => $liste,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }
}