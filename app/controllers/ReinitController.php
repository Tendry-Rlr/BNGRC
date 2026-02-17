<?php

namespace app\controllers;

use app\models\ReinitModel;
use Flight;

class ReinitController
{
    public function reinit()
    {
        $reinit = new ReinitModel(Flight::db());
        $reinit->reinit();
        Flight::redirect('/');
    }
}