<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%freelancer}}`.
 */
class m250303_102656_create_freelancer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%freelancer}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(), // Связь с таблицей user
            'skills' => $this->text(), // JSON или comma-separated string
            'experience' => $this->text(),
            'hourly_rate' => $this->decimal(10, 2),
            'portfolio' => $this->string(255),
            'availability' => $this->boolean()->defaultValue(true),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Создание индекса для user_id
        $this->createIndex(
            'idx-freelancer-user_id',
            '{{%freelancer}}',
            'user_id'
        );

        // Создание внешнего ключа для связи с таблицей user
        $this->addForeignKey(
            'fk-freelancer-user_id',
            '{{%freelancer}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE' // При удалении пользователя удалять и фрилансера
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаление внешнего ключа
        $this->dropForeignKey(
            'fk-freelancer-user_id',
            '{{%freelancer}}'
        );

        // Удаление индекса
        $this->dropIndex(
            'idx-freelancer-user_id',
            '{{%freelancer}}'
        );

        $this->dropTable('{{%freelancer}}');
    }
}
