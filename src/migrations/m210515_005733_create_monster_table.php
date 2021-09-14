<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%monster}}`.
 */
class m210515_005733_create_monster_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('monster', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'level' => $this->integer(),
            'health' => $this->integer(),
            'strength' => $this->integer(),
            'defense' => $this->integer(),
            'loot' => $this->integer(),
            'image' => $this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('monster');
    }
}
