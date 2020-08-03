<?php

use yii\db\Migration;

/**
 * Handles the creation of table `feedback`.
 */
class m180530_133910_create_feedback_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('feedback', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'email' => $this->string(64)->notNull(),
            'phone' => $this->string(32),
            'subject' => $this->string()->notNull(),
            'message' => $this->text()->notNull(),
            'read' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        $this->createIndex(
            'idx-feedback-read',
            'feedback',
            'read'
        );

        $this->createIndex(
            'idx-feedback-name',
            'feedback',
            'name'
        );

        $this->createIndex(
            'idx-feedback-email',
            'feedback',
            'email'
        );

        $this->createIndex(
            'idx-feedback-phone',
            'feedback',
            'phone'
        );

        $this->createIndex(
            'idx-feedback-subject',
            'feedback',
            'subject'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-feedback-read',
            'feedback'
        );

        $this->dropIndex(
            'idx-feedback-name',
            'feedback'
        );

        $this->dropIndex(
            'idx-feedback-email',
            'feedback'
        );

        $this->dropIndex(
            'idx-feedback-phone',
            'feedback'
        );

        $this->dropIndex(
            'idx-feedback-subject',
            'feedback'
        );

        $this->dropTable('feedback');
    }
}
