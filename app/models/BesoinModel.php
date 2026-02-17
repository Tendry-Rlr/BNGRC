<?php

namespace app\models;

use Flight;
use PDO;

class BesoinModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllBesoin()
    {
        $sql = "SELECT * FROM V_Besoin";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBesoinCategories()
    {
        $sql = "SELECT * FROM Besoin_Categorie";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBesoinByVille($id_ville)
    {
        $sql = "SELECT * FROM V_Besoin where id_Ville = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_ville]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function getBesoinFilleByCategory($id_besoin_categorie)
    {
        $sql = "SELECT id_Besoin_Fille FROM Besoin_Fille where id_Besoin_Categorie = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_besoin_categorie]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id_Besoin_Fille'];
    }

    public function getBesoinByNom($nombesoin)
    {
        $sql = "select 1 from Besoin where nom_Besoin = :nom";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nom' => $nombesoin]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveBesoin($id_besoin_categorie, $id_ville, $quantite, $nom)
    {
        $sql = "insert into Besoin(id_Ville, id_Besoin_Fille, quantite, nom_Besoin)
                values (:idville, :idbesoinfille, :qtte, :nombesoin)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idville' => $id_ville,
            ':idbesoinfille' => $this->getBesoinFilleByCategory($id_besoin_categorie),
            ':qtte' => $quantite,
            ':nombesoin' => $nom,
        ]);
    }

    public function getBesoinById($id)
    {
        $sql = "SELECT * FROM V_Besoin where id_Besoin = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBesoinRestant()
    {
        $sql = "SELECT * FROM V_Besoin WHERE quantite > 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSumBesoinRestant()
    {
        $sql = "SELECT COALESCE(SUM(prix_Unitaire * quantite), 0) AS sum FROM V_Besoin WHERE quantite > 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBesoin($id, $quantite)
    {
        $sql = "update Besoin set quantite = quantite - :qte where id_Besoin = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':qte' => $quantite, ':id' => $id]);
    }

    // Diminue la quantité d'un besoin spécifique (par id_Besoin exact)
    public function updateBesoinById($idBesoin, $quantite){
        $sql = "UPDATE Besoin SET quantite = quantite - :qte WHERE id_Besoin = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':qte' => $quantite, ':id' => $idBesoin]);
    }
    public function listebesoinProche($idBesoinFille)
    {
        $sql = "select quantite, id_Besoin from Besoin where id_Besoin_Fille = :id order by id_Besoin desc";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idBesoinFille]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}