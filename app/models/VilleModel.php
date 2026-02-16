<?php

namespace app\models;

use Flight;
use PDO;

class VilleModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getVillesByRegion($id_ville)
    {
        $sql = "SELECT * FROM Ville where id_Region= :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_ville]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}