<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m250303_102645_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(), // Связь с таблицей user
            'company_name' => $this->string(255),
            'contact_person' => $this->string(255),
            'phone' => $this->string(20),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Создание индекса для user_id
        $this->createIndex(
            'idx-client-user_id',
            '{{%client}}',
            'user_id'
        );

        // Создание внешнего ключа для связи с таблицей user
        $this->addForeignKey(
            'fk-client-user_id',
            '{{%client}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE' // При удалении пользователя удалять и клиента
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаление внешнего ключа
        $this->dropForeignKey(
            'fk-client-user_id',
            '{{%client}}'
        );

        // Удаление индекса
        $this->dropIndex(
            'idx-client-user_id',
            '{{%client}}'
        );

        $this->dropTable('{{%client}}');
    }
}
