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
                'title' => $this->string(128)->notNull(),
                'description' => $this->text()->notNull(),
            ],
            [
                'icon' => $this->string(128)->notNull(),
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
