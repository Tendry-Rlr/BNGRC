<?php

namespace app\controllers;

use app\models\BesoinModel;
use app\models\AchatModel;
use Flight;

class RecapitulationController
{
    public function recapitulation(){
        $besoin = new BesoinModel(Flight::db());
        $besoinRestant = $besoin->getBesoinRestant();
        $besoinSumRestant = $besoin->getSumBesoinRestant();
        $besoinSatisfait = $besoin->getBesoinSatisfait();
        $besoinSumSatisfait = $besoin->getSumBesoinSatisfait();

        $achat = new AchatModel(Flight::db());
        $achatTotaux = $achat->getAchatTotaux();
        $achatSumTotaux = $achat->getSumAchatTotaux();

        Flight::render('recapitulation', 
        ['baseUrl' => Flight::get('flight.base_url'),
        'besoinRestant'=> $besoinRestant,
        'besoinSumRestant'=> $besoinSumRestant,
        'besoinSatisfait'=> $besoinSatisfait,
        'besoinSumSatisfait'=> $besoinSumSatisfait,
        'achatTotaux'=>$achatTotaux,
        'achatSumTotaux'=>$achatSumTotaux
        ]);
    }

    public function recapitulationApi(){
        $besoin = new BesoinModel(Flight::db());
        $besoinRestant = $besoin->getBesoinRestant();
        $besoinSumRestant = $besoin->getSumBesoinRestant();
        $besoinSatisfait = $besoin->getBesoinSatisfait();
        $besoinSumSatisfait = $besoin->getSumBesoinSatisfait();

        $achat = new AchatModel(Flight::db());
        $achatTotaux = $achat->getAchatTotaux();
        $achatSumTotaux = $achat->getSumAchatTotaux();

        Flight::json([
            'besoinRestant' => $besoinRestant,
            'besoinSumRestant' => $besoinSumRestant,
            'besoinSatisfait' => $besoinSatisfait,
            'besoinSumSatisfait' => $besoinSumSatisfait,
            'achatTotaux' => $achatTotaux,
            'achatSumTotaux' => $achatSumTotaux
        ]);
    }
}