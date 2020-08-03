<?php

use yii\db\Migration;

/**
 * Handles the creation of table `social`.
 */
class m180602_191217_create_social_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('social', [
            'id' => $this->primaryKey(),
            'icon' => $this->string(128)->notNull(),
            'url' => $this->string()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('social');
    }
}
