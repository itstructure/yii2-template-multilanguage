<?php

use yii\db\Migration;

/**
 * Handles adding position_id to table `users`.
 */
class m190503_061946_add_position_id_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'position_id', $this->integer());

        $this->createIndex(
            'idx-users-position_id',
            'users',
            'position_id'
        );

        $this->addForeignKey(
            'fk-users-position_id',
            'users',
            'position_id',
            'positions',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-users-position_id',
            'users'
        );

        $this->dropIndex(
            'idx-users-position_id',
            'users'
        );

        $this->dropColumn('users', 'position_id');
    }
}
