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

    public function insertBesoin() {
        $id_besoin_categorie = Flight::request()->data->id_besoin_categorie;
        $id_ville = Flight::request()->data->id_ville;
        $quantite = Flight::request()->data->quantite;
        $nom = Flight::request()->data->nomBesoin;

        $besoin = new BesoinModel(Flight::db());
        $besoin->saveBesoin($id_besoin_categorie, $id_ville, $quantite, $nom);
        Flight::redirect('/');
    }
}