<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 */
class m250309_230001_create_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('application', [
            'id' => $this->primaryKey(),
            'freelancer_id' => $this->integer()->notNull(),
            'project_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'status' => "ENUM('pending', 'approved', 'declined') NOT NULL DEFAULT 'pending'",
            'reason_rejection' => $this->text(),
            'slug' => $this->string(255)->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Создаем индексы
        $this->createIndex('idx-application-freelancer_id', 'application', 'freelancer_id');
        $this->createIndex('idx-application-project_id', 'application', 'project_id');

        // Добавляем внешние ключи
        $this->addForeignKey(
            'fk-application-freelancer_id',
            'application',
            'freelancer_id',
            'freelancer',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-application-project_id',
            'application',
            'project_id',
            'project',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-application-freelancer_id', 'application');
        $this->dropForeignKey('fk-application-project_id', 'application');
        $this->dropTable('application');
    }
}