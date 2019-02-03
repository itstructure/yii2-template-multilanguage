<?php

use Itstructure\AdminModule\components\MultilanguageMigration;

/**
 * Handles the creation of table `about`.
 */
class m180531_134500_create_about_table extends MultilanguageMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createMultiLanguageTable('about',
            [
                'title' => $this->string(),
                'description' => $this->text(),
                'content' => $this->text(),
                'metaKeys' => $this->string(),
                'metaDescription' => $this->string(),
            ],
            [
                'default' => $this->tinyInteger(1)->defaultValue(0),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropMultiLanguageTable('about');
    }
}
