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
            'initUserStatus' => $this->tinyInteger(),
            'initUserRole' => $this->string(64),
            'regBlock' => $this->tinyInteger(),
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
