<?php

use yii\db\Migration;

/**
 * Class m200609_165203_add_alias_to_pages_table
 */
class m200609_165203_add_alias_to_pages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('pages', 'alias', $this->string());

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
            'idx-pages-alias',
            'pages'
        );

        $this->dropColumn('pages', 'alias');
    }
}
