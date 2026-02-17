<?php

namespace app\models;

use Flight;
use PDO;

class DonModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllDon()
    {
        $sql = "SELECT * FROM V_DonParVille";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVillebyDon($id_besoin)
    {
        $sql = "SELECT id_Ville FROM V_DonParVille where id_Besoin_Fille = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_besoin]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result === false) {
            return null; // ou throw new Exception("Ville introuvable pour le besoin $id_besoin");
        }
        
        return $result['id_Ville'];
    }
    public function insertDon($idBesoin, $quantite)
    {
        $idVille = $this->getVillebyDon($idBesoin);
        
        if ($idVille === null) {
            error_log("Impossible d'insérer le don: ville introuvable pour le besoin $idBesoin");
            return false;
        }

        $sql = "INSERT INTO Don (id_Besoin_Fille, quantite, id_Ville, date_Dispatch) VALUES (:besoin_id, :quantite, :ville_id, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':besoin_id' => $idBesoin,
            ':ville_id' => $idVille,
            ':quantite' => $quantite
        ]);
    }

    public function insertDonAvecVille($idBesoinFille, $quantite, $idVille)
    {
        $sql = "INSERT INTO Don (id_Besoin_Fille, quantite, id_Ville, date_Dispatch) VALUES (:besoin_fille_id, :quantite, :ville_id, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':besoin_fille_id' => $idBesoinFille,
            ':ville_id' => $idVille,
            ':quantite' => $quantite
        ]);
    }
    public function getDonByVille($idVille)
    {
        $sql = " SELECT * FROM V_DonParVille WHERE id_Ville = :id ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idVille]);
        $liste = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $liste;
    }

    public function getDonByIdBesoinFille($idf)
    {
        $sql = " SELECT * FROM Don WHERE id_Besoin_Fille = :id ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idf]);
        $liste = $stmt->fetch(PDO::FETCH_ASSOC);
        return $liste;
    }
    public function getDonByIdBesoin($id){
        $sql = "SELECT * FROM V_Besoin WHERE id_Besoin = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $liste = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $liste;
    }

    // Récupère tous les besoins des villes pour un id_Besoin_Fille donné
    public function getBesoinsByBesoinFille($idBesoinFille){
        $sql = "SELECT * FROM V_Besoin WHERE id_Besoin_Fille = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idBesoinFille]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insère un don avec id_Ville et id_Besoin_Fille directement
    public function insertDonDirect($idVille, $idBesoinFille, $quantite)
    {
        $sql = "INSERT INTO Don (id_Besoin_Fille, quantite, id_Ville, date_Dispatch) VALUES (:besoin_fille_id, :quantite, :ville_id, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':besoin_fille_id' => $idBesoinFille,
            ':ville_id' => $idVille,
            ':quantite' => $quantite
        ]);
    }

}
