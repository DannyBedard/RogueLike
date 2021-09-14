<?php


namespace app\models\frontend;

use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $confirmPassword;

    public function rules()
    {
        return [
            ['username', 'required', 'message' => "Veuillez choisir un nom d'utilisateur"],
            ['password', 'required', 'message' => 'Veuillez choisir un mot de passe'],
            ['password', 'compare', 'compareAttribute' => 'confirmPassword']
        ];
    }

    public function attributeLabels() {
        return [
            'username' => "Nom d'utilisateur",
            'password' => "Mot de passe",
            'confirmPassword' => "Veuillez confirmer votre mote de passe"
        ];
    }
}