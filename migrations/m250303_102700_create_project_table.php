<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%projects}}`.
 */
class m250303_102700_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'freelancer_id' => $this->integer(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'budget' => $this->decimal(10, 2),
            'file' => $this->string(255), // source file
            'final_file' => $this->string(255), // freelancer sending file
            'freelancer_response' => $this->text(), // Объяснение пользователя о выполнении проекта
            'freelancer_requisite' => $this->text(), // Текстовое поле, с реквизитами и способами оплаты фрилансеру за работу
            'deadline_date' => $this->date()->notNull(),
            'deadline_time' => $this->time()->notNull(),
            'status' => "ENUM('open', 'in progress', 'completed', 'canceled') NOT NULL DEFAULT 'open'",
            'slug' => $this->string(255)->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Создание индекса для client_id
        $this->createIndex(
            'idx-project-client_id',
            '{{%project}}',
            'client_id'
        );

        // Создание индекса для freelancer_id
        $this->createIndex(
            'idx-project-freelancer_id',
            '{{%project}}',
            'freelancer_id'
        );


        // Создание внешнего ключа для связи с таблицей client
        $this->addForeignKey(
            'fk-project-client_id',
            '{{%project}}',
            'client_id',
            '{{%client}}',
            'id',
            'CASCADE' // При удалении клиента удалять и его проекты
        );

        // Создание внешнего ключа для связи с таблицей freelancer
        $this->addForeignKey(
            'fk-project-freelancer_id',
            '{{%project}}',
            'freelancer_id',
            '{{%freelancer}}',
            'id',
            'SET NULL' // При удалении фрилансера не удалять проект, а просто обнулить freelancer_id
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаление внешних ключей
        $this->dropForeignKey(
            'fk-project-client_id',
            '{{%project}}'
        );
        $this->dropForeignKey(
            'fk-project-freelancer_id',
            '{{%project}}'
        );

        // Удаление индексов
        $this->dropIndex(
            'idx-project-client_id',
            '{{%project}}'
        );
        $this->dropIndex(
            'idx-project-freelancer_id',
            '{{%project}}'
        );


        $this->dropTable('{{%project}}');
    }
}