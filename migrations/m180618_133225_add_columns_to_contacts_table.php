<?php

use yii\db\Migration;

/**
 * Class m180618_133225_add_columns_to_contacts_table
 */
class m180618_133225_add_columns_to_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('contacts', 'mapQ', $this->string());
        $this->addColumn('contacts', 'mapZoom', $this->integer(3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('contacts', 'mapZoom');
        $this->dropColumn('contacts', 'mapQ');
    }
}
