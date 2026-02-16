<?php

namespace app\controllers;

use app\models\RegionModel;
use Flight;

class RecapitulationController
{
    public function recapitulation(){
        Flight::render('recapitulation', ['baseUrl' => Flight::get('flight.base_url')]);
    }
}