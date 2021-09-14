<?php

namespace app\models\core;

use app\models\backend\User;
use app\models\core\Classe;
use Yii;

class Paladin extends Classe
{
    public function __construct()
    {
        $this->name = 'Paladin';
        $this->health = 100;
        $this->strength = 10;
        $this->defense = 10;
        $this->image = "Paladin.jpg";
        $this->description = "Le Paladin se guéri de 1 point de vie par tour. Il a le pouvoir de faire apparaître un bouclier autour de lui pour se protéger des dégats pour le tour actuel et le prochain!";
        $this->spell = "Bouclier";
        $this->messageSpell = "Vous créer un bouclier autour de vous";
    }

    public function passive(){
        $session = Yii::$app->session;
        $session->open();
        $user = $user = User::findOne(['username' => \Yii::$app->user->identity->username]);

        if($session->get('userHealth') < $user->health)
            $session->set('userHealth', $session->get('userHealth') + 1);

        return "Vous vous guérissez de 1 point de vie";
    }

    public function spell(){
        $session = Yii::$app->session;
        $session->open();

        $session->set('state', 'miss');

        return $session->get('monsterHealth');
    }
}