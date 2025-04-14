<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $project_id
 * @property string $title
 * @property string|null $description
 * @property string|null $freelancer_response
 * @property string|null $file_task
 * @property string|null $upload_file
 * @property string $status
 * @property string $slug
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Project $project
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'title'], 'required'],
            [['project_id'], 'integer'],
            [['description', 'freelancer_response', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'upload_file'], 'string', 'max' => 255],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'freelancer_response' => Yii::t('app', 'Freelancer Response'),
            'upload_file' => Yii::t('app', 'Upload File'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    use SlugTrait;

    public static function getStatus(): array
    {
        return [
            'pending' => 'Ожидается',
            'in progress' => 'В процессе',
            'completed' => 'Завершен',
            'rejected' => 'Отклонен',
        ];
    }

    public function getStatusLabel(): string
    {
        $statuses = $this->getStatus();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : 'Неизвестный статус';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                // Генерация уникального slug
                $this->slug = $this->generateUniqueSlug($this->title);
            }
            return true;
        }
        return false;
    }
}
