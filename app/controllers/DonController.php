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

        // ID du Besoin_Fille (le type de produit choisi)
        $idBesoinFille = Flight::request()->data->dons; 
        $quantiteDonnee = Flight::request()->data->quantite;

        // Normaliser et valider la quantité donnée
        $quantiteDonnee = is_string($quantiteDonnee) ? str_replace(',', '.', $quantiteDonnee) : $quantiteDonnee;
        if (!is_numeric($quantiteDonnee) || (float)$quantiteDonnee <= 0) {
            Flight::halt(400, 'Quantité invalide');
        }
        $quantiteDonnee = (float)$quantiteDonnee;

        // Récupérer tous les besoins des villes pour ce type de produit
        $besoins = $don->getBesoinsByBesoinFille($idBesoinFille);

        if (empty($besoins)) {
            Flight::halt(400, 'Aucun besoin trouvé pour ce produit');
        }

        // Calculer le total des demandes de toutes les villes
        $totalDemandes = 0.0;
        foreach($besoins as $b){
            $bq = is_string($b['quantite']) ? str_replace(',', '.', $b['quantite']) : $b['quantite'];
            if (is_numeric($bq) && (float)$bq > 0) {
                $totalDemandes += (float)$bq;
            }
        }

        if ($totalDemandes <= 0) {
            Flight::halt(400, 'Total des demandes invalide');
        }

        // Distribuer proportionnellement aux villes
        foreach($besoins as $besoin){
            $demandVille = is_string($besoin['quantite']) ? str_replace(',', '.', $besoin['quantite']) : $besoin['quantite'];
            if (!is_numeric($demandVille) || (float)$demandVille <= 0) continue;
            
            $demandVille = (float)$demandVille;

            // Calcul proportionnel : (demande de cette ville / total demandes) * quantité donnée
            $quantitePourVille = floor(($demandVille / $totalDemandes) * $quantiteDonnee);

            if ($quantitePourVille > 0) {
                // Insérer le don pour cette ville
                $don->insertDonDirect($besoin['id_Ville'], $idBesoinFille, $quantitePourVille);
                
                // Diminuer le besoin de cette ville
                $besoinmodel->updateBesoinById($besoin['id_Besoin'], $quantitePourVille);
            }
        }

        Flight::redirect('/don');
    }
}