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

    public function getAllSimulation()
    {
        $sql = "SELECT * FROM Region";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}