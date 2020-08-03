<?php

use Itstructure\AdminModule\components\MultilanguageMigration;

/**
 * Handles the creation of table `home`.
 */
class m180603_123208_create_home_table extends MultilanguageMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createMultiLanguageTable('home',
            [
                'title' => $this->string(128),
                'description' => $this->text(),
                'content' => $this->text(),
                'metaKeys' => $this->string(128),
                'metaDescription' => $this->string(),
            ],
            [
                'default' => $this->tinyInteger()->defaultValue(0),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropMultiLanguageTable('home');
    }
}
