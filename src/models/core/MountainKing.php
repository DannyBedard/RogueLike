<?php

namespace app\models\core;

use app\models\core\Classe;
use Yii;

class MountainKing extends Classe
{
    public function __construct()
    {
        $this->name = 'Roi de la montagne';
        $this->health = 150;
        $this->strength = 5;
        $this->defense = 10;
        $this->image = "MountainKing.jpg";
        $this->description = "Le roi de la montagne a une chance sur 3 d'étourdir son adversaire pendant 1 tour. Une fois par tour, il peut faire une super attaque qui multiplie sa force par 2!";
        $this->spell = "Super Attaque";
        $this->messageSpell = "Vous avez fait une super Attaque";

    }

    public function passive(){
        $session = Yii::$app->session;
        $session->open();
        $random = rand(1, 3);

        if($session->get('state') === 'stun') {
            $session->set('state', 'miss');
            return "Étant assommé, l'ennemi ne vous attaque pas";
        }

        if($random === 3 && $session->get('state') != 'miss'){
            $session->set('state', 'stun');
            return 'Vous avez assommer';
        }
        return '';
    }

    public function spell(){
        $session = Yii::$app->session;
        $session->open();
        $monsterHealth = $this->battle($session->get('monsterHealth'), ($session->get('userStrength') * 2), $session->get('monsterDefense'));

        return $monsterHealth;
    }
}