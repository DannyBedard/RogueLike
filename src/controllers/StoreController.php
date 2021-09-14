<?php


namespace app\controllers;


use app\models\backend\User;
use yii\web\Controller;

class StoreController extends Controller
{
    public function actionIndex(){
        $user = User::findOne(['username' => \Yii::$app->user->identity->username]);
        $message = null;

        if (\Yii::$app->request->post('submit')==='zero'){
            $this->reset($user);
            $message = "Remise à zéro effectuer avec succès! N'oubliez pas de racheter d'autres points.";
        }
        if($user->gold >= 50){
            if (\Yii::$app->request->post('submit')==='health'){
                $this->upgradeStat('health', $user->health, $user);
                $message = "Achat effectuer avec succès!";
            }

            if (\Yii::$app->request->post('submit')==='strength'){
                $this->upgradeStat('strength', $user->strength, $user);
                $message = "Achat effectuer avec succès!";
            }

            if (\Yii::$app->request->post('submit')==='defense'){
                $this->upgradeStat('defense', $user->defense, $user);
                $message = "Achat effectuer avec succès!";
            }
        }
        else
            if(\Yii::$app->request->post())
                $message = "Vous n'avez pas assez d'or";

        $user = User::findOne(['username' => \Yii::$app->user->identity->username]);

        return $this->render('index', ['user' => $user, 'message' => $message]);
    }

    private function upgradeStat($stat, $actualValue, $user){
        if($stat === 'health')
            $value = 10;
        else
            $value = 1;
        \Yii::$app->db->createCommand()->update('user', [
            $stat => $actualValue + $value,
            'gold' => $user->gold - 50
        ],['username' => $user->username])->execute();
    }

    private function reset($user){
        $stats = ($user->health / 10) + $user->strength + $user->defense;
        $gold = $user->gold + ($stats * 40);
        \Yii::$app->db->createCommand()->update('user',[
            'gold' => $gold,
            'health' => 0,
            'strength' => 0,
            'defense' => 0
        ],['username' => $user->username])->execute();
    }
}