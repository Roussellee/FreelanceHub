<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property int $freelancer_id
 * @property int $project_id
 * @property string $description
 * @property string $reason_rejection
 * @property string $title
 * @property string $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string $slug
 *
 * @property Freelancer $freelancer
 * @property Project $project
 */
class Application extends \yii\db\ActiveRecord
{

    use SlugTrait;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['freelancer_id', 'project_id', 'description', 'title', 'status'], 'required'], // Добавьте 'status' здесь
            [['freelancer_id', 'project_id'], 'integer'],
            [['description', 'status', 'reason_rejection', 'title'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['freelancer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Freelancer::class, 'targetAttribute' => ['freelancer_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

//    public function rules()
//    {
//        return [
//            [['title', 'description', 'freelancer_id', 'project_id'], 'required'],
//            [['description'], 'string'],
//            [['freelancer_id', 'project_id'], 'integer'],
//            [['title'], 'string', 'max' => 255],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'freelancer_id' => 'Фрилансер',
            'project_id' => 'Проект',
            'description' => 'Почему вы подали заявку',
            'title' => 'Заголовок',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[Freelancer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFreelancer()
    {
        return $this->hasOne(Freelancer::class, ['id' => 'freelancer_id']);
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

    public function getStatus()
    {
        return [
            'pending' => 'Рассматриваемый',
            'approved' => 'Одобренный',
            'declined' => 'Отклонен',
        ];
    }

    public function getStatusLabel()
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
