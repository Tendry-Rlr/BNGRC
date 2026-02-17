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

        $don->insertDon($donne, $quantite);

        $besoin = new BesoinModel(Flight::db());
        $besoin->updateBesoin($donne, $quantite);

        Flight::redirect('/don');
    }

    public function proportionnelle(){
        $don = new DonModel(Flight::db());
        $besoinmodel = new BesoinModel(Flight::db());

        $idBesoinFille = Flight::request()->data->dons; 
        $quantiteDonnee = Flight::request()->data->quantite;

        $quantiteDonnee = is_string($quantiteDonnee) ? str_replace(',', '.', $quantiteDonnee) : $quantiteDonnee;
        if (!is_numeric($quantiteDonnee) || (float)$quantiteDonnee <= 0) {
            Flight::halt(400, 'Quantité invalide');
        }
        $quantiteDonnee = (float)$quantiteDonnee;

        $besoins = $don->getBesoinsByBesoinFille($idBesoinFille);

        if (empty($besoins)) {
            Flight::halt(400, 'Aucun besoin trouvé pour ce produit');
        }

        $besoinsFiltres = [];
        $totalDemandes = 0.0;
        
        foreach($besoins as $b){
            $qte = is_string($b['quantite']) ? str_replace(',', '.', $b['quantite']) : $b['quantite'];
            if (is_numeric($qte) && (float)$qte > 0) {
                $qteFloat = (float)$qte;
                $besoinsFiltres[] = [
                    'id_Besoin' => $b['id_Besoin'],
                    'id_Ville' => $b['id_Ville'],
                    'quantite' => $qteFloat
                ];
                $totalDemandes += $qteFloat;
            }
        }

        if ($totalDemandes <= 0) {
            Flight::halt(400, 'Total des demandes invalide');
        }

        $totalDistribue = 0.0;
        
        foreach($besoinsFiltres as $besoin){
            $proportion = $besoin['quantite'] / $totalDemandes;
            $quantiteCalculee = $proportion * $quantiteDonnee;
            $quantitePourVille = (int)floor($quantiteCalculee);

            if ($quantitePourVille > 0) {
                $don->insertDonProportionnel($besoin['id_Ville'], $idBesoinFille, $quantitePourVille);
                $besoinmodel->updateBesoinByIdProportionnel($besoin['id_Besoin'], $quantitePourVille);
                $totalDistribue += $quantitePourVille;
            }
        }

        Flight::redirect('/don');
    }

}