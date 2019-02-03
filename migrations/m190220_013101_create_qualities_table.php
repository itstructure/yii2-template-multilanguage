<?php

use Itstructure\AdminModule\components\MultilanguageMigration;

/**
 * Handles the creation of table `qualities`.
 */
class m190220_013101_create_qualities_table extends MultilanguageMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createMultiLanguageTable('qualities',
            [
                'title' => $this->string()->notNull(),
                'description' => $this->string(1024)->notNull(),
            ],
            [
                'icon' => $this->string(64)->notNull(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropMultiLanguageTable('qualities');
    }
}
