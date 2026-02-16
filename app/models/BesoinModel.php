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
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveBesoin($id_besoin_categorie, $id_ville, $quantite, $nom)
    {
        $sql = "insert into Besoin(id_Ville, id_Besoin_Fille, quantite, nom_Besoin)
                values (:idville, :idbesoinfille, :qtte, nombesoin)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':idville' => $id_ville,
            ':idbesoinfille' => $this->db->getBesoinFilleByCategory($id_besoin_categorie)['id_Besoin_Fille'],
            ':qtte' => $quantite,
            ':nombesoin' => $nom,
        ]);
    }
}