<?php


namespace app\controllers;


use app\models\backend\Monster;
use app\models\frontend\MonsterForm;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;

class AdminController extends Controller
{
    public function actionCreate(){
        $model = new MonsterForm();

        if($model->load(\Yii::$app->request->post())){
            $model->image = UploadedFile::getInstance($model, 'image');
            $model->upload();

            \Yii::$app->db->createCommand()->insert('monster', [
                'name' => $model->name,
                'level' => $model->level,
                'health' => $model->health,
                'strength' => $model->strength,
                'defense' =>$model->defense,
                'image' => $model->image,
                'loot' => $model->loot
            ])->execute();
            return $this->goHome();
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionIndex(){
        $query = Monster::find();
        $model = new MonsterForm();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $monsters = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if($model->load(Yii::$app->request->post()) && ['model' => $model]) {
            if (Yii::$app->request->post('submit') === 'update') {
                $this->updateMonster($model);
                return $this->goHome();
            }
            if (Yii::$app->request->post('submit') === 'delete') {
                \Yii::$app->db->createCommand()->delete('monster', [
                    'id' => $model->id
                ])->execute();
                return $this->goHome();
            }
        }

        if(Yii::$app->request->post()){
            $monster = $user = Monster::findOne(['id' => Yii::$app->request->post('submit')]);
            return $this->render('update', ['model' => $model,'monster' => $monster]);
        }

        return $this->render('index',[
            'monsters' => $monsters,
            'pagination' => $pagination,
        ]);
    }

    private function updateMonster($model){
        \Yii::$app->db->createCommand()->update('monster', [
            'name' => $model->name,
            'level' => $model->level,
            'health' => $model->health,
            'strength' => $model->strength,
            'defense' =>$model->defense,
            'loot' => $model->loot
        ],[
            'id' => $model->id
        ])->execute();
    }
}