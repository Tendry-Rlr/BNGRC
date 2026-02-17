<?php

namespace app\models;

use Flight;
use PDO;

class SimulationModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllAchatAttente(){
        $sql = "SELECT * FROM V_AchatAttente";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function simuler($qte, $id){
        $sql = "SELECT
            vb.id_Besoin AS id_Besoin,
            vb.nom_Besoin AS nom_Besoin,
            vb.quantite_actuelle AS quantite_actuelle,
            vb.prix_unitaire AS prix_unitaire,
            :qte AS simulate_qte,
            GREATEST(vb.quantite_actuelle - :qte, 0) AS quantite_apres,
            (:qte * vb.prix_unitaire) AS prix_total
        FROM V_BesoinSimulation vb
        WHERE vb.id_Besoin = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['qte' => $qte, 'id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function valider($attente, $idAttente){
        $idBesoin = $attente['id_Besoin'];
        $qte      = $attente['quantite'];
        $prix     = $attente['prix'] ?? 0;

        // 1. Diminuer la quantité du besoin
        $sql = "UPDATE Besoin SET quantite = quantite - :qte WHERE id_Besoin = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['qte' => $qte, 'id' => $idBesoin]);

        // 2. Insérer l'achat avec le montant
        $req = "INSERT INTO Achat (id_Besoin, quantite, montant, date) VALUES (:id, :qte, :montant, NOW())";
        $stm = $this->db->prepare($req);
        $stm->execute(['id' => $idBesoin, 'qte' => $qte, 'montant' => $prix]);

        // 3. Supprimer l'attente
        $del = "DELETE FROM Achat_Attente WHERE id_Achat_Attente = :id";
        $st = $this->db->prepare($del);
        $st->execute(['id' => $idAttente]);
    }

    public function annuler($id){
        $sql = "DELETE FROM Achat_Attente WHERE id_Achat_Attente = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

}