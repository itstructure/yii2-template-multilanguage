<?php

use yii\db\Migration;

/**
 * Class m180811_062040_add_column_reg_block_to_settings_table
 */
class m180811_062040_add_column_reg_block_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('settings', 'regBlock', $this->integer(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('settings', 'regBlock');
    }
}
