<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 */
class m250303_102706_create_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'reviewer_id' => $this->integer()->notNull(), // ID пользователя, оставившего отзыв
            'reviewee_id' => $this->integer()->notNull(), // ID пользователя, о ком отзыв
            'rating' => $this->integer()->notNull()->defaultValue(5), // От 1 до 5
            'comment' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Создание индекса для project_id
        $this->createIndex(
            'idx-review-project_id',
            '{{%review}}',
            'project_id'
        );

        // Создание индекса для reviewer_id
        $this->createIndex(
            'idx-review-reviewer_id',
            '{{%review}}',
            'reviewer_id'
        );
        // Создание индекса для reviewee_id
        $this->createIndex(
            'idx-review-reviewee_id',
            '{{%review}}',
            'reviewee_id'
        );

        // Создание внешнего ключа для связи с таблицей project
        $this->addForeignKey(
            'fk-review-project_id',
            '{{%review}}',
            'project_id',
            '{{%project}}',
            'id',
            'CASCADE' // При удалении проекта удалять и отзывы
        );

        // Создание внешнего ключа для связи с таблицей user (кто оставил отзыв)
        $this->addForeignKey(
            'fk-review-reviewer_id',
            '{{%review}}',
            'reviewer_id',
            '{{%user}}',
            'id',
            'CASCADE' // При удалении пользователя удалять и его отзывы
        );

        // Создание внешнего ключа для связи с таблицей user (о ком отзыв)
        $this->addForeignKey(
            'fk-review-reviewee_id',
            '{{%review}}',
            'reviewee_id',
            '{{%user}}',
            'id',
            'CASCADE' // При удалении пользователя удалять и его отзывы
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаление внешних ключей
        $this->dropForeignKey(
            'fk-review-project_id',
            '{{%review}}'
        );
        $this->dropForeignKey(
            'fk-review-reviewer_id',
            '{{%review}}'
        );
        $this->dropForeignKey(
            'fk-review-reviewee_id',
            '{{%review}}'
        );

        // Удаление индексов
        $this->dropIndex(
            'idx-review-project_id',
            '{{%review}}'
        );
        $this->dropIndex(
            'idx-review-reviewer_id',
            '{{%review}}'
        );
        $this->dropIndex(
            'idx-review-reviewee_id',
            '{{%review}}'
        );
        $this->dropTable('{{%review}}');
    }
}
