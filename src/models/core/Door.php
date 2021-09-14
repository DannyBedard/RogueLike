<?php

namespace app\models\core;

use Yii;

abstract class Door
{
    public $name;
    public $action;
    public $model;

    protected function updateSession(){
        $session = Yii::$app->session;
        $session->open();
        $session->set('monster', true);
        $session->set('door1', true);
        $session->set('door2', true);
    }

    protected function monsterSession($monster){
        $session = Yii::$app->session;
        $session->open();
        $session->set('monsterId', $monster->id);
        $session->set('monsterHealth', $monster->health);
        $session->set('monsterStrength', $monster->strength);
        $session->set('monsterDefense', $monster->defense);
        $session->set('monsterLevel', $monster->level);
        $session->set('loot', $monster->loot);
        $session->set('monster', false);
    }
}