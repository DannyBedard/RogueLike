<?php

namespace app\models\frontend;

use app\models\backend\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            //['password', 'validatePassword'],
        ];
    }

    public function attributeLabels() {
        return [
            'username' => "Nom d'utilisateur",
            'password' => "Mot de passe",
            'rememberMe' => "Se souvenir de moi"
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        /*if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$this->getUser()->validatePassword($this->password, $this->getUser()->password)) {
                $this->addError($attribute, 'Incorrect username or password.'. $this->username);
            }
        }*/
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login($logUser)
    {
        if ($this->validate()) {
            return Yii::$app->user->login($logUser, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        return User::findOne(['username' => $this->username]);
    }
}
