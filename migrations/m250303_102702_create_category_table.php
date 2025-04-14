<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m250303_102702_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Создание таблицы категорий без поля description
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Добавление поля category_id в таблицу projects
        $this->addColumn('{{%project}}', 'category_id', $this->integer()->notNull());

        // Создание внешнего ключа для связи с таблицей category
        $this->addForeignKey(
            'fk-project-category_id',
            '{{%project}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE' // При удалении категории удалять проекты, связанные с ней
        );

        // Создание индекса для category_id
        $this->createIndex(
            'idx-project-category_id',
            '{{%project}}',
            'category_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаление внешнего ключа
        $this->dropForeignKey(
            'fk-project-category_id',
            '{{%project}}'
        );

        // Удаление индекса
        $this->dropIndex(
            'idx-project-category_id',
            '{{%project}}'
        );

        // Удаление поля category_id из таблицы projects
        $this->dropColumn('{{%project}}', 'category_id');

        // Удаление таблицы категорий
        $this->dropTable('{{%category}}');
    }
}
