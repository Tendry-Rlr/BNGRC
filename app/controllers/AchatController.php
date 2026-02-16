<?php

namespace app\controllers;

use app\models\AchatModel;
use app\models\BesoinModel;
use app\models\VilleModel;
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

    public function insertAchat()
    {
        $quantite = Flight::request()->data->quantite;
        $id_besoin = Flight::request()->data->id_besoin;
        $id_besoin_categorie = Flight::request()->data->id_besoin_categorie;
        $id_ville = Flight::request()->data->id_ville;
        $pU = Flight::request()->data->pU;
        $quantite_besoin = Flight::request()->data->quantite_besoin;

        $achat = new AchatModel(Flight::db());
        $result = $achat->saveAchat($id_besoin, $id_besoin_categorie, $id_ville, $quantite, $pU, $quantite_besoin);
        
        if ($result['success']) {
            Flight::redirect("/besoinville/".$id_ville."?success=" . urlencode($result['message']));
        } else {
            Flight::redirect("/achat/".$id_besoin."?error=" . urlencode($result['error']));
        }
    }
}