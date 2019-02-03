<?php

use yii\db\Migration;

/**
 * Handles the creation of table `about_qualities`.
 * Has foreign keys to the tables:
 *
 * - `about`
 * - `qualities`
 */
class m190220_013549_create_junction_table_for_about_and_qualities_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('about_qualities', [
            'about_id' => $this->integer(),
            'qualities_id' => $this->integer(),
            'PRIMARY KEY(about_id, qualities_id)',
        ]);

        // creates index for column `about_id`
        $this->createIndex(
            'idx-about_qualities-about_id',
            'about_qualities',
            'about_id'
        );

        // add foreign key for table `about`
        $this->addForeignKey(
            'fk-about_qualities-about_id',
            'about_qualities',
            'about_id',
            'about',
            'id',
            'CASCADE'
        );

        // creates index for column `qualities_id`
        $this->createIndex(
            'idx-about_qualities-qualities_id',
            'about_qualities',
            'qualities_id'
        );

        // add foreign key for table `qualities`
        $this->addForeignKey(
            'fk-about_qualities-qualities_id',
            'about_qualities',
            'qualities_id',
            'qualities',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `about`
        $this->dropForeignKey(
            'fk-about_qualities-about_id',
            'about_qualities'
        );

        // drops index for column `about_id`
        $this->dropIndex(
            'idx-about_qualities-about_id',
            'about_qualities'
        );

        // drops foreign key for table `qualities`
        $this->dropForeignKey(
            'fk-about_qualities-qualities_id',
            'about_qualities'
        );

        // drops index for column `qualities_id`
        $this->dropIndex(
            'idx-about_qualities-qualities_id',
            'about_qualities'
        );

        $this->dropTable('about_qualities');
    }
}
