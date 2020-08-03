<?php

use yii\db\Migration;

/**
 * Handles the creation of table `login_attempts`.
 */
class m180810_121801_create_login_attempts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('login_attempts', [
            'id' => $this->primaryKey(),
            'key'=> $this->string()->notNull(),
            'amount'=> $this->tinyInteger()->null()->defaultValue(1),
            'reset_at'=> $this->integer()->null()->defaultValue(null),
            'updated_at'=> $this->integer()->null()->defaultValue(null),
            'created_at'=> $this->integer()->null()->defaultValue(null),
        ]);

        $this->createIndex(
            'idx-login_attempts-key',
            'login_attempts',
            'key'
        );

        $this->createIndex(
            'idx-login_attempts-amount',
            'login_attempts',
            'amount'
        );

        $this->createIndex(
            'idx-login_attempts-reset_at',
            'login_attempts',
            'reset_at'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-login_attempts-key',
            'login_attempts'
        );

        $this->dropIndex(
            'idx-login_attempts-amount',
            'login_attempts'
        );

        $this->dropIndex(
            'idx-login_attempts-reset_at',
            'reset_at'
        );

        $this->dropTable('login_attempts');
    }
}
