<?php


namespace app\models\frontend;

use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\base\Model;

class MonsterForm extends Model
{
    public $id;
    public $name;
    public $level;
    public $health;
    public $strength;
    public $defense;
    public $loot;
    public $image;

    public function rules(){
        return [
            ['name', 'required', 'message' => 'Veuillez donner un nom'],
            ['level', 'required', 'message' => 'Veuillez donner un niveau'],
            ['health', 'required', 'message' => 'Veuillez entrer un nombre'],
            ['strength', 'required', 'message' => 'Veuillez entrer un nombre'],
            ['defense', 'required', 'message' => 'Veuillez entrer un nombre'],
            ['loot', 'required', 'message' => 'Veuillez entrer un nombre'],
            ['id', 'required', 'message' => 'Ceci est un ID'],
            ['image', 'file', 'extensions' => 'png, jpg']
        ];
    }

    public function attributeLabels() {
        return [
            'name' => 'Nom',
            'level' => 'Niveau',
            'health' => 'Vie',
            'strength' => 'Force',
            'defense' => 'Défense',
            'loot' => 'Récompense',
        ];
    }

    public function upload(){
        if($this->validate()){
            $this->image->saveAs($this->uploadPath() . $this->name . "." . $this->image->extension);
            $this->image = $this->name . "." . $this->image->extension;
        }
    }

    public function uploadPath(){
        return Url::to('images/');
    }
}