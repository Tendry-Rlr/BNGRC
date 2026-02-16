<?php

namespace app\controllers;

use app\models\SimulationModel;
use app\models\AchatModel;

use Flight;

class SimulationController
{
    public function getSimulation(){
        $simulationModel = new SimulationModel(Flight::db());
        $achatAttente = $simulationModel->getAllAchatAttente();

        Flight::render('simulation', [
            'achatAttente' => $achatAttente,
            'baseUrl' => Flight::get('flight.base_url')
        ]);
    }

    public function simulation(){
        $simulationModel = new SimulationModel(Flight::db());

        $id = Flight::request()->data->attente;

        $achatModel = new AchatModel(Flight::db());
        $attente = $achatModel->getAchatByAttente($id);

        $liste = $simulationModel->simuler($attente['quantite'], $id);

        $achatAttente = $simulationModel->getAllAchatAttente();

        Flight::render('simulation', [
            'simulations' => $liste,
            'achatAttente' => $achatAttente,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }

    public function validation(){
        $simulationModel = new SimulationModel(Flight::db());

        $id = Flight::request()->data->attente;

        $achatModel = new AchatModel(Flight::db());
        $attente = $achatModel->getAchatByAttente($id);

        $simulationModel->valider($attente['id_Besoin'], $id);
        $achatAttente = $simulationModel->getAllAchatAttente();

        Flight::render('simulation', [
            'achatAttente' => $achatAttente,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }
}