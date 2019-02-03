<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m171230_122107_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'login' => $this->string(),
            'email' => $this->string(),
            'hashedPassword' => $this->string(),
            'status' => $this->integer(2),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
