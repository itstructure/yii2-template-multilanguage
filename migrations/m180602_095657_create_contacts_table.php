<?php

use Itstructure\AdminModule\components\MultilanguageMigration;

/**
 * Handles the creation of table `contacts`.
 */
class m180602_095657_create_contacts_table extends MultilanguageMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createMultiLanguageTable('contacts',
            [
                'title' => $this->string(128)->notNull(),
                'address' => $this->string(128),
                'email' => $this->string(128),
                'phone' => $this->string(128),
                'metaKeys' => $this->string(128)->notNull(),
                'metaDescription' => $this->string()->notNull(),
            ],
            [
                'default' => $this->tinyInteger()->defaultValue(0),
                'mapQ' => $this->string(128),
                'mapZoom' => $this->tinyInteger(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropMultiLanguageTable('contacts');
    }
}
