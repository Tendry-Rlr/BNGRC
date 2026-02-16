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

    public function getAchatByAttente($id)
    {
        $sql = "SELECT * FROM Achat_Attente WHERE id_Achat_Attente = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // public function getPrixDon($idville, $id_besoin)
    // {
    //     $besoin = new BesoinModel(Flight::db());
    //     $besoinById = $besoin->getBesoinById($id_besoin)['id_Besoin_Fille'];

    //     $don = new DonModel(Flight::db());
    //     $prixDon = $don->getDonByIdBesoinFille($besoinById)['quantite'];
    //     return $prixDon;
    // }

    public function getPrixDon($idville)
    {
        $sql = "select quantite_Don from V_DonParVille where id_Ville = :id and nom_Produit = 'Argent'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idville]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['quantite_Don'] ?? 0;
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
        $prixDonTotal = $this->getPrixDon($id_ville);
        if ($prixDonTotal === 0) {
            return [
                'success' => false,
                'error' => "Cette ville n'a pas encore reçu de don en argent."
            ];
        }
        if ($prixFrais > $prixDonTotal) {
            return [
                'success' => false,
                'error' => 'Le prix avec frais (' . number_format((float) $prixFrais, 2) . ' Ar) dépasse le montant des dons disponibles (' . number_format((float) $prixDonTotal, 2) . ' Ar)'
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

    public function getAllAchat()
    {
        $sql = "SELECT a.*, v.nom_Besoin, v.prix_Unitaire, v.quantite as quantite_besoin, v.id_Ville as id_Ville
            FROM Achat a
            LEFT JOIN V_Besoin v ON a.id_Besoin = v.id_Besoin";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAchatByVille($idville)
    {
        // Récupère les achats pour une ville en joignant les informations de besoin, ville et région
        $sql = "SELECT a.*, b.nom_Besoin, b.quantite as quantite_besoin, v.nom_Ville, r.nom_Region, d.date_Dispatch as date_dispatch
            FROM Achat a
            LEFT JOIN Besoin b ON a.id_Besoin = b.id_Besoin
            LEFT JOIN Ville v ON b.id_Ville = v.id_Ville
            LEFT JOIN Region r ON v.id_Region = r.id_Region
            LEFT JOIN Don d ON a.id_Don = d.id_Don
            WHERE v.id_Ville = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idville]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAchatDetails()
    {
        // Récupère tous les achats avec détails (besoin, ville, région, date)
        $sql = "SELECT a.*, b.nom_Besoin, b.quantite as quantite_besoin, v.nom_Ville, r.nom_Region, d.date_Dispatch as date_dispatch
            FROM Achat a
            LEFT JOIN Besoin b ON a.id_Besoin = b.id_Besoin
            LEFT JOIN Ville v ON b.id_Ville = v.id_Ville
            LEFT JOIN Region r ON v.id_Region = r.id_Region
            LEFT JOIN Don d ON a.id_Don = d.id_Don";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}