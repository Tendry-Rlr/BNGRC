<?php

namespace app\controllers;

use Flight;

class SimulationController
{
    public function getSimulation(){
        Flight::render('simulation', [
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }
}