<?php

use Itstructure\AdminModule\components\MultilanguageMigration;

/**
 * Handles the creation of table `pages`.
 */
class m180508_092223_create_pages_table extends MultilanguageMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createMultiLanguageTable('pages',
            [
                'title' => $this->string(),
                'description' => $this->text(),
                'content' => $this->text(),
                'metaKeys' => $this->string(),
                'metaDescription' => $this->string(),
            ],
            [
                'parentId' => $this->integer(),
                'active' => $this->tinyInteger(1)->notNull()->defaultValue(0),
                'icon' => $this->string(64)
            ]
        );

        $this->createIndex(
            'idx-pages-parentId',
            'pages',
            'parentId'
        );

        $this->createIndex(
            'idx-pages-active',
            'pages',
            'active'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-pages-parentId',
            'pages'
        );

        $this->dropIndex(
            'idx-pages-active',
            'pages'
        );

        $this->dropMultiLanguageTable('pages');
    }
}
