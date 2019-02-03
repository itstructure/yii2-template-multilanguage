<?php

use yii\db\Migration;

/**
 * Handles the creation of table `about_technologies`.
 * Has foreign keys to the tables:
 *
 * - `about`
 * - `technologies`
 */
class m180601_035106_create_junction_table_for_about_and_technologies_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('about_technologies', [
            'about_id' => $this->integer(),
            'technologies_id' => $this->integer(),
            'PRIMARY KEY(about_id, technologies_id)',
        ]);

        // creates index for column `about_id`
        $this->createIndex(
            'idx-about_technologies-about_id',
            'about_technologies',
            'about_id'
        );

        // add foreign key for table `about`
        $this->addForeignKey(
            'fk-about_technologies-about_id',
            'about_technologies',
            'about_id',
            'about',
            'id',
            'CASCADE'
        );

        // creates index for column `technologies_id`
        $this->createIndex(
            'idx-about_technologies-technologies_id',
            'about_technologies',
            'technologies_id'
        );

        // add foreign key for table `technologies`
        $this->addForeignKey(
            'fk-about_technologies-technologies_id',
            'about_technologies',
            'technologies_id',
            'technologies',
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
            'fk-about_technologies-about_id',
            'about_technologies'
        );

        // drops index for column `about_id`
        $this->dropIndex(
            'idx-about_technologies-about_id',
            'about_technologies'
        );

        // drops foreign key for table `technologies`
        $this->dropForeignKey(
            'fk-about_technologies-technologies_id',
            'about_technologies'
        );

        // drops index for column `technologies_id`
        $this->dropIndex(
            'idx-about_technologies-technologies_id',
            'about_technologies'
        );

        $this->dropTable('about_technologies');
    }
}
