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
        $listeCategorie = $besoin->getAllBesoinCategories();
        
        Flight::render('donForm', [
            'listeBesoin' => $listeBesoin,
            'listeCategorie' => $listeCategorie,
            'listeDon' => $liste,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }

    public function donner(){
        $don = new DonModel(Flight::db());
        $besoin = new BesoinModel(Flight::db());

        $idBesoin = Flight::request()->data->dons; 
        $quantite = Flight::request()->data->quantite;

        $besoinData = $besoin->getBesoinById($idBesoin);
        
        if (!$besoinData) {
            Flight::halt(400, 'Besoin introuvable');
        }

        $don->insertDonDirect($besoinData['id_Ville'], $besoinData['id_Besoin_Fille'], $quantite);
        $besoin->updateBesoinById($idBesoin, $quantite);

        Flight::redirect('/don');
    }

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

    public function petitDons()
    {
        $don = new DonModel(Flight::db());
        $besoin = new BesoinModel(Flight::db());

        $idBesoinFille = Flight::request()->data->dons; 
        $quantiteDonnee = (int)Flight::request()->data->quantite;

        $besoins = $besoin->getBesoinbyBesoinFille($idBesoinFille);

        $quantiteRestante = $quantiteDonnee;

        foreach ($besoins as $b) {
            if ($quantiteRestante <= 0) {
                break;
            }

            $besoinVille = (int)$b['quantite'];
            $quantiteADonner = min($quantiteRestante, $besoinVille);

            if($quantiteADonner > 0) {
                $don->insertDonDirect($b['id_Ville'], $idBesoinFille, $quantiteADonner);
                $besoin->updateBesoinById($b['id_Besoin'], $quantiteADonner);
                $quantiteRestante -= $quantiteADonner;
            }

            if($besoinVille - $quantiteADonner > 0) {
                break;
            }
        }

        Flight::redirect('/don');
    }

    public function proportionnelle()
    {
        $don = new DonModel(Flight::db());
        $besoinmodel = new BesoinModel(Flight::db());

        $idBesoinFille = Flight::request()->data->dons;
        $quantiteDonnee = Flight::request()->data->quantite;

        $quantiteDonnee = is_string($quantiteDonnee) ? str_replace(',', '.', $quantiteDonnee) : $quantiteDonnee;
        if (!is_numeric($quantiteDonnee) || (float) $quantiteDonnee <= 0) {
            Flight::halt(400, 'Quantité invalide');
        }
        $quantiteDonnee = (float) $quantiteDonnee;

        $besoins = $don->getBesoinsByBesoinFille($idBesoinFille);

        if (empty($besoins)) {
            Flight::halt(400, 'Aucun besoin trouvé pour ce produit');
        }

        $besoinsFiltres = [];
        $totalDemandes = 0.0;

        foreach ($besoins as $b) {
            $qte = is_string($b['quantite']) ? str_replace(',', '.', $b['quantite']) : $b['quantite'];
            if (is_numeric($qte) && (float) $qte > 0) {
                $qteFloat = (float) $qte;
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

        $distributions = [];
        $totalFloor = 0;

        foreach ($besoinsFiltres as $besoin) {
            $quantiteExacte = ($besoin['quantite'] / $totalDemandes) * $quantiteDonnee;
            $quantiteFloor = (int) floor($quantiteExacte);
            $decimal = $quantiteExacte - $quantiteFloor;

            $distributions[] = [
                'id_Besoin' => $besoin['id_Besoin'],
                'id_Ville' => $besoin['id_Ville'],
                'quantite_floor' => $quantiteFloor,
                'decimal' => $decimal,
                'quantite_finale' => $quantiteFloor
            ];

            $totalFloor += $quantiteFloor;
        }

        $reste = (int) $quantiteDonnee - $totalFloor;
        
        if ($reste > 0) {
            usort($distributions, function($a, $b) {
                return $b['decimal'] <=> $a['decimal'];
            });
            
            for ($i = 0; $i < $reste && $i < count($distributions); $i++) {
                $distributions[$i]['quantite_finale']++;
            }
        }
        
        foreach($distributions as $dist){
            if ($dist['quantite_finale'] > 0) {
                $don->insertDonDirect($dist['id_Ville'], $idBesoinFille, $dist['quantite_finale']);
                $besoinmodel->updateBesoinById($dist['id_Besoin'], $dist['quantite_finale']);
            }
        }

        Flight::redirect('/don');
    }
}