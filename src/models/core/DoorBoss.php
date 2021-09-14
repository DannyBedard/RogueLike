<?php

namespace app\models\core;

use app\models\backend\Monster;
use app\models\backend\User;
use app\models\core\Door;
use Yii;

class DoorBoss extends Door
{
    public function __construct()
    {
        $this->name = 'Boss';
        $this->action = 'battle';
    }
    public function action(){
        $user = User::findOne(['username' => \Yii::$app->user->identity->username]);
        $session = Yii::$app->session;
        $session->open();
        $monster = Monster::findOne(['level' => 100 * $user->level]);
        $this->monsterSession($monster);
        return $monster;
    }
}