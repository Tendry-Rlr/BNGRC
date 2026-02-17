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

    // public function donner(){
    //     $don= new DonModel(Flight::db());

    //     $donne = Flight::request()->data->dons; 
    //     $quantite = Flight::request()->data->quantite;

    //     $don->insertDon($donne, $quantite);

    //     $besoin = new BesoinModel(Flight::db());
    //     $besoin->updateBesoin($donne, $quantite);

    //     Flight::redirect('/don');
    // }

    // public function petitDons(){
    //     $don= new DonModel(Flight::db());

    //     $bf = Flight::request()->data->dons; 
    //     $quantite = Flight::request()->data->quantite;

    //     $besoin = new BesoinModel(Flight::db());

    //     $besoins= $besoin->getBesoinbyBesoinFille($bf);

    //     foreach($besoins as $b){
    //         if($quantite > 0) {
    //             $don->insertDon($b['id_Besoin_Fille'], $quantite, $b['id_Ville']);
    //             $besoin->updateBesoin($b['id_Besoin'], $quantite);
    //             $quantite= $quantite - $quantite;
    //         } else {
    //             break;
    //         }
    //     }

    //     Flight::redirect('/don');
    // } 

    public function petitDons(){
        $don = new DonModel(Flight::db());
        $besoin = new BesoinModel(Flight::db());

        $bf = Flight::request()->data->dons; 
        $quantiteDonnee = (int)Flight::request()->data->quantite;

        $besoins = $besoin->getBesoinbyBesoinFille($bf);

        $quantiteRestante = $quantiteDonnee;

        foreach($besoins as $b) {
            if($quantiteRestante <= 0) {
                break;
            }

            $besoinVille = (int)$b['quantite'];

            // On donne le minimum entre ce qui reste et le besoin de cette ville
            $quantiteADonner = min($quantiteRestante, $besoinVille);

            if($quantiteADonner > 0) {
                $don->insertDon($b['id_Besoin_Fille'], $quantiteADonner, $b['id_Ville']);
                $besoin->updateBesoin($b['id_Besoin'], $quantiteADonner);
                $quantiteRestante -= $quantiteADonner;
            }

            // On ne passe à la ville suivante que si le besoin de celle-ci est tombé à 0
            if($besoinVille - $quantiteADonner > 0) {
                break;
            }
        }

        Flight::redirect('/don');
    }
}