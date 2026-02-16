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

    public function getAchatByAttente($id) {
        $sql = "SELECT * FROM Achat_Attente WHERE id_Achat_Attente = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}