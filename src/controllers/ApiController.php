<?php


namespace app\controllers;


use app\models\backend\User;
use app\models\core\BloodMage;
use app\models\core\DemonHunter;
use app\models\core\MountainKing;
use app\models\core\Paladin;
use yii\web\Controller;
use Yii;

class ApiController extends Controller
{
    public function init()
    {
        parent::init();
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
    }

    public function actionAttack(){
        $session = Yii::$app->session;
        $session->open();
        $user = $user = User::findOne(['username' => \Yii::$app->user->identity->username]);
        $class = $this->newClass($user->class);

        if(Yii::$app->request->post()){
            $message = $class->passive();
            $monsterDamage = 0;

            $monsterHealth = $this->battle($session->get('monsterHealth'), $session->get('userStrength'), $session->get('monsterDefense'));
            $userDamage = $session->get('monsterHealth') - $monsterHealth;
            $session->set('monsterHealth', $monsterHealth);

            if($session->get('state') != 'miss' && $monsterHealth > 0) {
                $userHealth = $this->battle($session->get('userHealth'), $session->get('monsterStrength'), $session->get('userDefense'));
                $monsterDamage = $session->get('userHealth') - $userHealth;
                $session->set('userHealth', $userHealth);
            }
            else {
                $session->set('state', '');
                $userHealth = $session->get('userHealth');
            }

            if($userHealth === 0) {
                $session->set('progress', 0);
                $this->losingSession($user);
            }
            if($monsterHealth === 0){
                if($session->get('monsterLevel') > 99)//boss
                    $this->bossVictory($user);
                else
                    $this->victory($user);
                $this->updateSession();
            }

            return [$userHealth, $monsterHealth, $userDamage, $monsterDamage ,$message, $session->get('state')];
        }
        return ['erreur'];
    }

    public function actionSpell(){
        $session = Yii::$app->session;
        $session->open();
        $userHealth = $session->get('userHealth');
        $monsterHealth = $session->get('monsterHealth');
        $monsterDamage = 0;
        $userDamage = 0;
        $message = "Votre pouvoir n'est pas disponible!";
        if($session->get('spell')) {
            $user = $user = User::findOne(['username' => \Yii::$app->user->identity->username]);
            $class = $this->newClass($user->class);
            $session->set('spell', false);

            $message = $class->messageSpell;
            $monsterHealth = $class->spell();
            $userDamage = $session->get('monsterHealth') - $monsterHealth;
            $session->set('monsterHealth', $monsterHealth);

            if ($session->get('state') != 'miss' && $monsterHealth > 0) {
                $userHealth = $this->battle($session->get('userHealth'), $session->get('monsterStrength'), $session->get('userDefense'));
                $monsterDamage = $session->get('userHealth') - $userHealth;
                $session->set('userHealth', $userHealth);
            }
        }
            return [$userHealth, $monsterHealth, $userDamage, $monsterDamage, $message];
    }

    public function battle($health, $strength, $defense){
        $result =  $health - (rand(1, 10) + $strength - $defense);

        if($result <= 0 ){
            return 0;
        }
        elseif ($result > $health)
            return $health;
        else
            return $result;
    }

    private function updateSession(){
        $session = Yii::$app->session;
        $session->open();

        $session->set('monster', true);
        $session->set('door1', true);
        $session->set('door2', true);
        $session->set('poison', false);
        $session->set('spell', true);
    }

    private function losingSession($user){
        $session = Yii::$app->session;
        $session->open();

        $session->set('userHealth', $user->health);
        $session->set('userStrength', $user->strength);
        $session->set('userDefense', $user->defense);
        $session->set('progress', 0);
        $this->updateSession();
    }

    private function bossVictory($user){
        $session = Yii::$app->session;
        $session->open();
        $session->set('progress', 0);
        $this->updateSession();
        \Yii::$app->db->createCommand()->update('user', [
            'gold' => $user->gold + $session->get('loot'),
            'level' => $user->level +1],
            ['username' => $user->username])->execute();
    }

    private function victory($user){
        $session = Yii::$app->session;
        $session->open();

        \Yii::$app->db->createCommand()->update('user', [
            'gold' => $user->gold + $session->get('loot')],
            ['username' => $user->username])->execute();
        $session->set('progress', $session->get('progress') + 1);
    }

    private function newClass($user){
        switch($user){
            case 'BloodMage':
                return new BloodMage();
            case 'DemonHunter':
                return new DemonHunter();
            case 'MountainKing':
                return new MountainKing();
            case 'Paladin':
                return new Paladin();
        }
    }

}