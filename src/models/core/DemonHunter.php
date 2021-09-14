<?php

namespace app\models\core;

use app\models\core\Classe;
use Yii;

class DemonHunter extends Classe
{
    public function __construct()
    {
        $this->name = 'Chasseur de démon';
        $this->health = 100;
        $this->strength = 15;
        $this->defense = 5;
        $this->image = "DemonHunter.png";
        $this->description = "Le chasseur de démon à 1 chance sur 3 d'éviter une attaque qui lui est destiné. Il peut tirer une flèche empoisonnée sur son ennemi 1 fois par combat, l'adversaire subit alors 1 point de dégât supplémentaire par tour!";
        $this->spell = "Flèche empoisonnée";
        $this->messageSpell = "L'ennemi reçoit 1 dommage de poison";
    }

    public function passive(){
        $session = Yii::$app->session;
        $session->open();
        $random = rand(1, 3);
        $message = "";

        if($session->get('poison')) {
            $message = $this->messageSpell;
            $session->set('monsterHealth', $session->get('monsterHealth') - 1);
        }

        if($random === 3) {
            $session->set('state', 'miss');

            if($session->get('poison'))
                $message = "Vous évitez l'attaque de l'ennemi, il reçoit également 1 point de dégât de poison";
            else
                return "Vous évitez l'attaque de l'ennemi";
        }

        return $message;
    }

    public function spell(){
        $session = Yii::$app->session;
        $session->open();
        $session->set('poison', true);
        $monsterHealth = $this->battle($session->get('monsterHealth'), ($session->get('userStrength')), $session->get('monsterDefense'));

        return $monsterHealth - 2;
    }
}