<?php

namespace app\controllers;

use app\models\backend\Monster;
use app\models\backend\User;
use app\models\core\BloodMage;
use app\models\core\DemonHunter;
use app\models\core\DoorBoss;
use app\models\core\MountainKing;
use app\models\frontend\CreateForm;
use app\models\frontend\GameForm;
use app\models\core\DoorBattle;
use app\models\core\DoorBonus;
use app\models\core\DoorHeal;
use app\models\core\Paladin;
use Yii;
use yii\web\Controller;

class GameController extends Controller
{
    public function actionIndex(){
        $session = Yii::$app->session;
        $session->open();
        $model = new GameForm();
        $user = $user = User::findOne(['username' => \Yii::$app->user->identity->username]);
        $door1 = $this->newDoor(1);
        $door2 = $this->newDoor(2);
        $class = $this->newClass($user->class);

        if($session->get('userHealth') == NULL)
            $this->setSession($user);

        if($user->level > 5)
            return $this->render('victory');

        if (\Yii::$app->request->post('submit')==='door1'){
            return $this->render($door1->action, ['user' => $user, 'door' => $door1, 'class' => $class]);
        }
        if (\Yii::$app->request->post('submit')==='door2'){
            return $this->render($door2->action, ['user' => $user, 'door' => $door2, 'class' => $class]);
        }

        return $this->render('index', ['model' => $model, 'door1' => $door1, 'door2' => $door2]);
    }

    public function actionCreate(){
        $model = new CreateForm();
        $class = new Paladin();
        $auth = \Yii::$app->authManager;
        $user = $user = User::findOne(['username' => \Yii::$app->user->identity->username]);

        if(\Yii::$app->request->post('submit') === 'detail'){
            $model->load(\Yii::$app->request->post());
            $class = $this->newClass($model->choice);
        }else{
            if($model->load(\Yii::$app->request->post())){
                $class = $this->newClass($model->choice);
                \Yii::$app->db->createCommand()->update('user', [
                    'class' => $model->choice,
                    'authKey' => 'ready',
                    'gold' => '20',
                    'health' => $class->health,
                    'strength' => $class->strength,
                    'defense' => $class->defense,
                    'level' => 1,
                    'image' => $class->image
                ], ['username' => $user->username])->execute();
                $auth->assign($auth->getRole('ready'), $user->getId());
                $this->setSession($user);
                return $this->goHome();
            }
        }
        $model = new CreateForm();
        return $this->render('create', ['model' => $model, 'class' => $class]);
    }

    private function newClass($choice){
        switch ($choice){
            case 'MountainKing' :
                $class = new MountainKing();
                break;
            case 'BloodMage' :
                $class = new BloodMage();
                break;
            case 'DemonHunter' :
                $class = new DemonHunter();
                break;
            case 'Paladin' :
                $class = new Paladin();
                break;
        }
        return $class;
    }

    private function newDoor($n){
        $session = Yii::$app->session;
        $session->open();
        if($session->get('door1') === true){
            $session->set('door1', rand(1, 100));
            $session->set('door2', rand(1, 100));
        }
        if($n ===1)
            $num = $session->get('door1');
        if($n ===2)
            $num = $session->get('door2');

        $boss = $this->doorBoss($session->get('progress'));

        $door = new DoorBattle();
        if($num >40 && $num <= 60)
            $door = new DoorHeal();
        if($num >60 && $num <= 70)
            $door = new DoorBonus();
        if($num <= $boss)
            $door = new DoorBoss();

        return $door;
    }

    private function doorBoss($progress){
        switch ($progress){
            case 6:
                return 10;
            case 7:
                return 20;
            case 8:
                return 30;
            case 9:
                return 50;
            case 10:
                return 100;
        }
        return -1;
    }

    private function setSession($user){
        $session = Yii::$app->session;
        $session->open();
        $session->set('username', $user->username);
        $session->set('userHealth', $user->health);
        $session->set('userStrength', $user->strength);
        $session->set('userDefense', $user->defense);
        $session->set('progression', 0);
    }
}