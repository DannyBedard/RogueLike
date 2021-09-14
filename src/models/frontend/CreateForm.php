<?php


namespace app\models\frontend;


use yii\base\Model;

class CreateForm extends Model
{
    public $choice = array(''=>'','DemonHunter'=>'Chasseur de démon', 'BloodMage'=>'Mage de sang', 'Paladin'=>'Paladin', 'MountainKing'=>'Roi de la montagne');

    public function rules(){
        return [
            ['choice', 'required', 'message' => 'Veuillez choisir une classe'],
        ];
    }

    public function attributeLabels() {
        return [
            'choice' => 'Choisissez votre classe'
        ];
    }
}