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

    public function insertDon($idBesoin, $quantite)
    {
        $sql = "INSERT INTO Don (id_Besoin_Fille, quantite, date_Dispatch) VALUES (:besoin_id, :quantite, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':besoin_id' => $idBesoin,
            ':quantite' => $quantite
        ]);
    }
}