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

    public function getAchatByVille() {

    }

    public function saveAchat($id_besoin, $id_besoin_categorie, $quantite) {
        
    }

}