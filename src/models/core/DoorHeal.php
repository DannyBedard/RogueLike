<?php

namespace app\models\core;

use app\models\backend\User;
use app\models\core\Door;
use Yii;

class DoorHeal extends Door
{
    public function __construct()
    {
        $this->name = 'Guérison';
        $this->action = 'heal';
    }

    public function action(){
        $user = User::findOne(['username' => \Yii::$app->user->identity->username]);
        $session = Yii::$app->session;
        $session->open();
        if($session->get('userHealth') + 50 >= $user->health)
            $session->set('userHealth', $user->health);
        else
            $session->set('userHealth', $session->get('userHealth') + 50);
        $this->updateSession();
    }
}