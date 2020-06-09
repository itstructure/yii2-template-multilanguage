<?php

use yii\db\Migration;

/**
 * Class m200609_165214_add_alias_to_products_table
 */
class m200609_165214_add_alias_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('products', 'alias', $this->string());

        $this->createIndex(
            'idx-products-alias',
            'products',
            'alias'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-products-alias',
            'products'
        );

        $this->dropColumn('products', 'alias');
    }
}
