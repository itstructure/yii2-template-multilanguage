<?php

use Itstructure\AdminModule\components\MultilanguageMigration;

/**
 * Handles the creation of table `articles`.
 */
class m180509_092225_create_articles_table extends MultilanguageMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createMultiLanguageTable('articles',
            [
                'title' => $this->string(128)->notNull(),
                'description' => $this->text(),
                'content' => $this->text(),
                'metaKeys' => $this->string(128),
                'metaDescription' => $this->string(),
            ],
            [
                'pageId' => $this->integer(),
                'active' => $this->tinyInteger()->notNull()->defaultValue(0),
                'icon' => $this->string(128),
                'alias' => $this->string(128),
            ]
        );

        $this->createIndex(
            'idx-articles-pageId',
            'articles',
            'pageId'
        );

        $this->addForeignKey(
            'fk-articles-pageId',
            'articles',
            'pageId',
            'pages',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            'idx-articles-active',
            'articles',
            'active'
        );

        $this->createIndex(
            'idx-articles-alias',
            'articles',
            'alias'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-articles-alias',
            'articles'
        );

        $this->dropIndex(
            'idx-articles-active',
            'articles'
        );

        $this->dropForeignKey(
            'fk-articles-pageId',
            'articles'
        );

        $this->dropIndex(
            'idx-articles-pageId',
            'articles'
        );

        $this->dropMultiLanguageTable('articles');
    }
}
