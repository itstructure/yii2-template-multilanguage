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
            'first_name' => $this->string(64),
            'last_name' => $this->string(64),
            'patronymic' => $this->string(64),
            'login' => $this->string(64),
            'email' => $this->string(64),
            'phone' => $this->string(64),
            'hashedPassword' => $this->string(),
            'status' => $this->tinyInteger(),
            'public' => $this->tinyInteger(),
            'order' => $this->tinyInteger(),
            'about' => $this->text(),
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
