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
                'title' => $this->string()->notNull(),
                'address' => $this->string(128),
                'email' => $this->string(64),
                'phone' => $this->string(32),
                'metaKeys' => $this->string()->notNull(),
                'metaDescription' => $this->string()->notNull(),
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
        $this->dropMultiLanguageTable('contacts');
    }
}
