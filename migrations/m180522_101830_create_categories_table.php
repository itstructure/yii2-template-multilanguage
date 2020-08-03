<?php

use Itstructure\AdminModule\components\MultilanguageMigration;

/**
 * Handles the creation of table `categories`.
 */
class m180522_101830_create_categories_table extends MultilanguageMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createMultiLanguageTable('categories',
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
            'idx-categories-parentId',
            'categories',
            'parentId'
        );

        $this->createIndex(
            'idx-categories-active',
            'categories',
            'active'
        );

        $this->createIndex(
            'idx-categories-alias',
            'categories',
            'alias'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-categories-parentId',
            'categories'
        );

        $this->dropIndex(
            'idx-categories-active',
            'categories'
        );

        $this->dropIndex(
            'idx-categories-alias',
            'categories'
        );

        $this->dropMultiLanguageTable('categories');
    }
}
