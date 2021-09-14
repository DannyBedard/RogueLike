<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rbac}}`.
 */
class m210527_001806_create_rbac_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('auth_assignment', [
            'item_name' => $this->string()->notNull(),
            'user_id' => $this->string()->notNull(),
            'created_at' => $this->integer()
        ]);

        $this->createTable('auth_item', [
            'name' => $this->string()->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->createTable('auth_item_child', [
            'parent' => $this->string()->notNull(),
            'child' => $this->string()->notNull(),
        ]);

        $this->createTable('auth_item', [
            'name' => $this->string()->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->createTable('migration', [
            'version' => $this->string()->notNull(),
            'apply_time' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rbac}}');
    }
}
