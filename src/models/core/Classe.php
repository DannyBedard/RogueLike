<?php

namespace app\models\core;

abstract class Classe
{
    public $name;
    public $health;
    public $strength;
    public $defense;
    public $image;
    public $description;
    public $spell;
    public $messageSpell;

    protected function battle($health, $strength, $defense){
        $result =  $health - (rand(1, 10) + $strength - $defense);

        if($result <= 0 ){
            return 0;
        }
        elseif ($result > $health)
            return $health;
        else
            return $result;

    }
}