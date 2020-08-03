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
                'title' => $this->string(128)->notNull(),
                'description' => $this->text(),
                'content' => $this->text(),
                'metaKeys' => $this->string(128),
                'metaDescription' => $this->string(),
            ],
            [
                'parentId' => $this->integer(),
                'active' => $this->tinyInteger()->notNull()->defaultValue(0),
                'icon' => $this->string(128),
                'alias' => $this->string(128),
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

        $this->createIndex(
            'idx-pages-alias',
            'pages',
            'alias'
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

        $this->dropIndex(
            'idx-pages-alias',
            'pages'
        );

        $this->dropMultiLanguageTable('pages');
    }
}
