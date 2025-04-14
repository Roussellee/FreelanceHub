<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m250303_083925_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'role' => "ENUM('client', 'freelancer', 'admin') NOT NULL",
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Добавление индекса для username (полезно для поиска)
        $this->createIndex(
            'idx-user-username',
            '{{%user}}',
            'username'
        );

        // Добавление индекса для email (полезно для поиска)
        $this->createIndex(
            'idx-user-email',
            '{{%user}}',
            'email'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаление индексов при откате
        $this->dropIndex(
            'idx-user-username',
            '{{%user}}'
        );
        $this->dropIndex(
            'idx-user-email',
            '{{%user}}'
        );

        $this->dropTable('{{%user}}');
    }
}
