<?php

use app\models\backend\User;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210510_192913_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'password' => $this->string(),
            'authKey' => $this->string(),
            'accessToken' => $this->string(),
            'gold' => $this->integer(),
            'health' => $this->integer(),
            'strength' => $this->integer(),
            'defense' => $this->integer(),
            'class' => $this->string(),
            'level' => $this->integer(),
            'image' => $this->string()
        ]);

        \Yii::$app->db->createCommand()->insert('user', [
            'username' => 'admin',
            'password' =>\Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'authKey' => 'admin'
        ])->execute();

        $auth = \Yii::$app->authManager;
        $adminRole = $auth->createRole('admin');
        $ready = $auth->createRole('ready');
        $auth->add($adminRole);
        $auth->add($ready);

        $auth->assign($adminRole, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \Yii::$app->authManager->removeAll();
        $admin = User::findByUsername('admin');
        if($admin !=false)
            $admin->delete();

        $this->dropTable('user');
    }
}