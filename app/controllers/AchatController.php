<?php

namespace app\controllers;

use app\models\AchatModel;
use app\models\BesoinModel;
use Flight;

class AchatController
{
    public function redirectAchat($id_besoin)
    {
        $besoin = new BesoinModel(Flight::db());
        $besoinById = $besoin->getBesoinById($id_besoin);

        Flight::render('achat-form', [
            'besoin' => $besoinById,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }

    public function insertAchat() {
        $quantite = Flight::request()->data->quantite;
        $id_besoin = Flight::request()->data->id_besoin;
        $id_besoin_categorie = Flight::request()->data->id_besoin_categorie;

        $achat = new AchatModel(Flight::db());
        $achat->saveAchat($id_besoin, $id_besoin_categorie, $quantite);
    }
}