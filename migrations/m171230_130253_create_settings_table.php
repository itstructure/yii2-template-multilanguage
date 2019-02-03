<?php

use yii\db\Migration;

/**
 * Handles the creation of table `settings`.
 */
class m171230_130253_create_settings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('settings', [
            'initUserStatus' => $this->integer(2),
            'initUserRole' => $this->string(64),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('settings');
    }
}
