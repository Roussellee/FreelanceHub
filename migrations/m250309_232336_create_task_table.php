<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m250309_232336_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
//            'freelancer_id' => $this->integer(), // Под вопросом, нужно ли
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'file_task' => $this->string(255), // Файл, который отправляет заказчик для задачи

            'freelancer_response' => $this->text(),
            'upload_file' => $this->string(255), // Файл, который загружает фрилансер

            'status' => "ENUM('pending', 'in progress', 'completed', 'rejected') NOT NULL DEFAULT 'pending'",
            'slug' => $this->string(255)->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Создание индекса для project_id
        $this->createIndex(
            'idx-task-project_id',
            '{{%task}}',
            'project_id'
        );

        // Создание внешнего ключа для связи с таблицей project
        $this->addForeignKey(
            'fk-task-project_id',
            '{{%task}}',
            'project_id',
            '{{%project}}',
            'id',
            'CASCADE' // При удалении проекта удалять и связанные задачи
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаление внешнего ключа
        $this->dropForeignKey(
            'fk-task-project_id',
            '{{%task}}'
        );

        // Удаление индекса
        $this->dropIndex(
            'idx-task-project_id',
            '{{%task}}'
        );

        $this->dropTable('{{%task}}');
    }
}