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
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'patronymic' => $this->string(),
            'login' => $this->string(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'hashedPassword' => $this->string(),
            'status' => $this->integer(2),
            'public' => $this->integer(2),
            'order' => $this->integer(3),
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
