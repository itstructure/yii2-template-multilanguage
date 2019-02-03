<?php

use Itstructure\AdminModule\components\MultilanguageMigration;

/**
 * Handles the creation of table `products`.
 */
class m180524_101831_create_products_table extends MultilanguageMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createMultiLanguageTable('products',
            [
                'title' => $this->string(),
                'description' => $this->text(),
                'content' => $this->text(),
                'metaKeys' => $this->string(),
                'metaDescription' => $this->string(),
            ],
            [
                'pageId' => $this->integer(),
                'active' => $this->tinyInteger(1)->notNull()->defaultValue(0),
                'icon' => $this->string(64),
            ]
        );

        $this->createIndex(
            'idx-products-pageId',
            'products',
            'pageId'
        );

        $this->addForeignKey(
            'fk-products-pageId',
            'products',
            'pageId',
            'pages',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            'idx-products-active',
            'products',
            'active'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-products-active',
            'products'
        );

        $this->dropForeignKey(
            'fk-products-pageId',
            'products'
        );

        $this->dropIndex(
            'idx-products-pageId',
            'products'
        );

        $this->dropMultiLanguageTable('products');
    }
}
