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


    public function hasDonArgent($idville)
    {
        $sql = "SELECT COUNT(*) AS nb FROM V_DonParVille WHERE id_Ville = :id AND nom_produit = 'Argent'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idville]);
        return (int)($stmt->fetch(PDO::FETCH_ASSOC)['nb'] ?? 0) > 0;
    }

    public function getPrixDon($idville)
    {
        $sqlDon = "SELECT COALESCE(SUM(quantite_don), 0) AS total_don FROM V_DonParVille WHERE id_Ville = :id AND nom_produit = 'Argent'";
        $stmtDon = $this->db->prepare($sqlDon);
        $stmtDon->execute([':id' => $idville]);
        $totalDon = (float)($stmtDon->fetch(PDO::FETCH_ASSOC)['total_don'] ?? 0);

        $sqlAchat = "SELECT COALESCE(SUM(prix), 0) AS total_achat FROM Achat_Attente WHERE id_Ville = :id";
        $stmtAchat = $this->db->prepare($sqlAchat);
        $stmtAchat->execute([':id' => $idville]);
        $totalAchat = (float)($stmtAchat->fetch(PDO::FETCH_ASSOC)['total_achat'] ?? 0);

        return $totalDon - $totalAchat;
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
        if ($quantite > $quantite_besoin) {
            return [
                'success' => false,
                'error' => 'La quantité demandée (' . $quantite . ') dépasse la quantité du besoin (' . $quantite_besoin . ')'
            ];
        }

        $prix = $pU * $quantite;
        $pourcentage = $this->getPourcentageByCategory($id_besoin_categorie);
        $prixFrais = $prix + ($prix * $pourcentage);

        $prixDonTotal = $this->getPrixDon($id_ville);
        if (!$this->hasDonArgent($id_ville)) {
            return [
                'success' => false,
                'error' => "Cette ville n'a pas encore reçu de don en argent."
            ];
        }
        if ($prixDonTotal <= 0) {
            return [
                'success' => false,
                'error' => "Cette ville n'a plus d'argent disponible pour effectuer des achats."
            ];
        }
        if ($prixFrais > $prixDonTotal) {
            return [
                'success' => false,
                'error' => 'Le prix avec frais (' . number_format((float) $prixFrais, 2) . ' Ar) dépasse le solde disponible (' . number_format((float) $prixDonTotal, 2) . ' Ar)'
            ];
        }

        $sql = "insert into Achat_Attente
            (id_Ville, id_Besoin, date_dispatch, quantite, prix) values
            (:idv, :idb, NOW(), :qtte, :prix)
        ";
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

        $sqlUpdateBesoin = "UPDATE Besoin SET quantite = quantite - :qte WHERE id_Besoin = :id";
        $stmtUpdate = $this->db->prepare($sqlUpdateBesoin);
        $stmtUpdate->execute([':qte' => $quantite, ':id' => $id_besoin]);

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
        $sql = "select COALESCE(sum(montant), 0) as sum from Achat where id_Besoin in (select id_Besoin from Besoin where quantite = 0)";
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
        $sql = "SELECT a.id_Achat, a.quantite, a.montant, a.date,
                       b.nom_Besoin, b.id_Ville,
                       v.nom_Ville, r.nom_Region
                FROM Achat a
                LEFT JOIN Besoin b ON a.id_Besoin = b.id_Besoin
                LEFT JOIN Ville v ON b.id_Ville = v.id_Ville
                LEFT JOIN Region r ON v.id_Region = r.id_Region
                WHERE v.id_Ville = :id
                ORDER BY a.date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idville]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAchatDetails()
    {
        $sql = "SELECT a.id_Achat, a.quantite, a.montant, a.date,
                       b.nom_Besoin, b.id_Ville,
                       v.nom_Ville, r.nom_Region
                FROM Achat a
                LEFT JOIN Besoin b ON a.id_Besoin = b.id_Besoin
                LEFT JOIN Ville v ON b.id_Ville = v.id_Ville
                LEFT JOIN Region r ON v.id_Region = r.id_Region
                ORDER BY a.date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}