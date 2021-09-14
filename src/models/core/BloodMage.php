<?php

namespace app\models\core;

use app\models\backend\User;
use app\models\core\Classe;
use Yii;

class BloodMage extends Classe
{
    public function __construct()
    {
        $this->name = 'Mage de sang';
        $this->health = 90;
        $this->strength = 7;
        $this->defense = 7;
        $this->image = "BloodMage.jpg";
        $this->description = "Le mage de sang peut lancer son pouvoir d'explosion morbide à tous les tours, cependant à chaque fois qu'il le lance, il subit 1 de dégât. Il a également une chance sur 4 de se guérir complètement à chaque tour.";
        $this->spell = "Explosion Morbide";
        $this->messageSpell = "Vous subissez 1 point de dégât collatéraux dût à votre explosion";
    }

    public function passive(){
        $session = Yii::$app->session;
        $session->open();
        $random = rand(1, 4);
        $user = $user = User::findOne(['username' => \Yii::$app->user->identity->username]);

        if($random === 3) {
            $session->set('userHealth', $user->health);
            return "Vous vous guérissez totalement!";
        }
        return "";
    }

    public function spell(){
        $session = Yii::$app->session;
        $session->open();
        $monsterHealth = $this->battle($session->get('monsterHealth'), ($session->get('userStrength') * 2), $session->get('monsterDefense'));
        $session->set('spell', true);
        $session->set('userHealth', $session->get('userHealth') - 1);

        return $monsterHealth;
    }
}