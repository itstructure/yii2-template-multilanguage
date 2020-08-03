<?php

use Itstructure\AdminModule\components\MultilanguageMigration;

/**
 * Handles the creation of table `positions`.
 */
class m190502_163142_create_positions_table extends MultilanguageMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createMultiLanguageTable('positions',
            [
                'name' => $this->string(64),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropMultiLanguageTable('positions');
    }
}
