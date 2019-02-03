<?php

use yii\db\Migration;

/**
 * Handles the creation of table `contacts_social`.
 * Has foreign keys to the tables:
 *
 * - `contacts`
 * - `social`
 */
class m180602_191712_create_junction_table_for_contacts_and_social_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('contacts_social', [
            'contacts_id' => $this->integer(),
            'social_id' => $this->integer(),
            'PRIMARY KEY(contacts_id, social_id)',
        ]);

        // creates index for column `contacts_id`
        $this->createIndex(
            'idx-contacts_social-contacts_id',
            'contacts_social',
            'contacts_id'
        );

        // add foreign key for table `contacts`
        $this->addForeignKey(
            'fk-contacts_social-contacts_id',
            'contacts_social',
            'contacts_id',
            'contacts',
            'id',
            'CASCADE'
        );

        // creates index for column `social_id`
        $this->createIndex(
            'idx-contacts_social-social_id',
            'contacts_social',
            'social_id'
        );

        // add foreign key for table `social`
        $this->addForeignKey(
            'fk-contacts_social-social_id',
            'contacts_social',
            'social_id',
            'social',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `contacts`
        $this->dropForeignKey(
            'fk-contacts_social-contacts_id',
            'contacts_social'
        );

        // drops index for column `contacts_id`
        $this->dropIndex(
            'idx-contacts_social-contacts_id',
            'contacts_social'
        );

        // drops foreign key for table `social`
        $this->dropForeignKey(
            'fk-contacts_social-social_id',
            'contacts_social'
        );

        // drops index for column `social_id`
        $this->dropIndex(
            'idx-contacts_social-social_id',
            'contacts_social'
        );

        $this->dropTable('contacts_social');
    }
}
