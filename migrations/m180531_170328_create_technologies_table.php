<?php

use yii\db\Migration;

/**
 * Handles the creation of table `technologies`.
 */
class m180531_170328_create_technologies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('technologies', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'share' => $this->tinyInteger(),
            'icon' => $this->string(128),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('technologies');
    }
}
