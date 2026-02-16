<?php

namespace app\models;

use Flight;
use PDO;

class AchatModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getPrixDon($idville, $id_besoin)
    {   
        $besoin = new BesoinModel(Flight::db());
        $besoinById = $besoin->getBesoinById($id_besoin)['id_Besoin_Fille'];

        $don = new DonModel(Flight::db());
        $prixDon = $don->getDonByIdBesoinFille($besoinById)['quantite'];
    }

    protected function getPourcentageByCategory($id_besoin_categorie)
    {
        $sql = "select frais_Pourcentage from Achat_Fille where id_Besoin_Categorie = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_besoin_categorie]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['frais_Pourcentage'] ?? 0;
    }

    public function saveAchat($id_besoin, $id_besoin_categorie, $id_ville, $quantite, $pU, $quantite_besoin)
    {
        // Validation 1 : Quantité ne doit pas dépasser la quantité du besoin
        if ($quantite > $quantite_besoin) {
            return [
                'success' => false,
                'error' => 'La quantité demandée (' . $quantite . ') dépasse la quantité du besoin (' . $quantite_besoin . ')'
            ];
        }

        $prix = $pU * $quantite;
        $pourcentage = $this->getPourcentageByCategory($id_besoin_categorie);
        $prixFrais = $prix + ($prix * $pourcentage);

        // Validation 2 : Prix avec frais ne doit pas dépasser le montant total des dons
        $prixDonTotal = $this->getPrixDon($id_ville, $id_besoin);
        if ($prixFrais > $prixDonTotal) {
            return [
                'success' => false,
                'error' => 'Le prix avec frais (' . number_format((float)$prixFrais, 2) . ' Ar) dépasse le montant des dons disponibles (' . number_format((float)$prixDonTotal, 2) . ' Ar)'
            ];
        }

        // Si toutes les validations passent, insérer dans Achat_Attente
        $sql = "insert into Achat_Attente
            (id_Ville, id_Besoin, date_dispatch, quantite, prix) values
            (:idv, :idb, NOW(), :qtte, :prix)
        ";
        // recalculer le prix avec les mêmes règles mais via la méthode interne
        $prix = $pU * $quantite;
        $pourcentage = $this->getPourcentageByCategory($id_besoin_categorie);
        $prixFrais = $prix + ($prix * $pourcentage);

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idv' => $id_ville,
            ':idb' => $id_besoin,
            ':qtte' => $quantite,
            ':prix' => $prixFrais,
        ]);

        return [
            'success' => true,
            'message' => 'Achat enregistré avec succès'
        ];
    }

    public function getAchatTotaux(){
        $sql = "select * from Achat  join V_Besoin on Achat.id_Besoin = V_Besoin.id_Besoin where V_Besoin.id_Besoin in (select id_Besoin from V_Besoin where quantite = 0)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);    
    }

    public function getSumAchatTotaux(){
        $sql = "select sum(montant) as sum  from Achat where id_Besoin in (select id_Besoin from Besoin where quantite = 0)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }

}