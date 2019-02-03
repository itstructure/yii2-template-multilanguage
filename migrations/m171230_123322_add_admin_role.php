<?php

use yii\db\Migration;

/**
 * Handles the addition of admin role to rbac table `auth_item`.
 */
class m171230_123322_add_admin_role extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->db->createCommand()
            ->insert('auth_item', [
                'name' => 'admin',
                'type' => 1,
                'description' => 'Admin role.',
                'created_at' => time(),
                'updated_at' => time(),
            ])
            ->execute();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {

    }
}
