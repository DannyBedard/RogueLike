<?php

namespace app\models\core;

use app\models\backend\Monster;
use app\models\backend\User;
use app\models\core\Door;
use Yii;

class DoorBattle extends Door
{
    public function __construct()
    {
        $this->name = 'Combat';
        $this->action = 'battle';
    }

    public function action(){
        $user = User::findOne(['username' => \Yii::$app->user->identity->username]);
        $session = Yii::$app->session;
        $session->open();
        if($session->get('monster')) {
            $monster = Monster::find()->andWhere(['level' => $user->level])->orderBy('RAND()')->one();
            $this->monsterSession($monster);
        }
        else
            $monster = Monster::findOne(['id' => $session->get('monsterId')]);
        return $monster;
    }
}