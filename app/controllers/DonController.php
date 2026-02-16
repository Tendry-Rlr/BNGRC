<?php

namespace app\controllers;

use app\models\DonModel;
use app\models\BesoinModel;

use Flight;

class DonController
{
    public function listeDon()
    {
        $don = new DonModel(Flight::db());
        $besoin = new BesoinModel(Flight::db());
        $liste = $don->getAllDon();
        $listeBesoin = $besoin->getAllBesoin();
        Flight::render('donForm', [
            'listeBesoin' => $listeBesoin,
            'listeDon' => $liste,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }

    public function donner(){
        $don= new DonModel(Flight::db());

        $donne = Flight::request()->data->dons; 
        $quantite = Flight::request()->data->quantite;

        $besoin = new BesoinModel(Flight::db());
        $listeBesoin = $besoin->getAllBesoin();

        $don->insertDon($donne, $quantite);

        Flight::redirect('/don');

    }
}