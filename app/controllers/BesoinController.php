<?php

namespace app\controllers;

use app\models\BesoinModel;
use app\models\DonModel;
use app\models\VilleModel;
use Flight;

class BesoinController
{
    public function insertBesoin()
    {
        $id_besoin_categorie = Flight::request()->data->id_besoin_categorie;
        $id_ville = Flight::request()->data->id_ville;
        $quantite = Flight::request()->data->quantite;
        $nom = Flight::request()->data->nomBesoin;

        $besoin = new BesoinModel(Flight::db());
        $besoin->saveBesoin($id_besoin_categorie, $id_ville, $quantite, $nom);
        Flight::redirect('/besoinville/' . $id_ville);
    }

    public function loadInsert()
    {
        $besoin = new BesoinModel(Flight::db());
        $categories = $besoin->getAllBesoinCategories();

        $ville = new VilleModel(Flight::db());
        $villes = $ville->getAllVille();

        Flight::render('besoin-form', [
            'besoinCategories' => $categories,
            'villes' => $villes,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }

    public function besoinProche()
    {
        $quantite = floatval(Flight::request()->data->quantite);
        $idBesoinFille = Flight::request()->data->dons;

        $besoin = new BesoinModel(Flight::db());
        $bp = $besoin->listebesoinProche($idBesoinFille);

        $don = new DonModel(Flight::db());
        $quantiteRestante = $quantite;

        foreach ($bp as $b) {
            if ($quantiteRestante <= 0) {
                break;
            }

            $quantiteBesoin = floatval($b['quantite']);
            if ($quantiteBesoin <= 0) {
                continue;
            }

            $quantiteADonner = min($quantiteRestante, $quantiteBesoin);

            $don->insertDon($idBesoinFille, $quantiteADonner);
            $besoin->updateBesoinById($b['id_Besoin'], $quantiteADonner);

            $quantiteRestante -= $quantiteADonner;
        }

        Flight::redirect('/don');
    }
}