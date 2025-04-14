<?php

namespace app\models;

use Yii;
use yii\helpers\Inflector;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property int $client_id
 * @property int|null $freelancer_id
 * @property string $title
 * @property string|null $description
 * @property string|null $freelancer_response
 * @property string|null $freelancer_requisite
 * @property float|null $budget
 * @property string|null $file
 * @property string|null $final_file
 * @property string $deadline_date
 * @property string $deadline_time
 * @property string $status
 * @property string $slug
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $category_id
 *
 * @property Application[] $applications
 * @property Category $category
 * @property Client $client
 * @property Freelancer $freelancer
 * @property Review[] $reviews
 * @property Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    use SlugTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'title', 'deadline_date', 'deadline_time', 'category_id'], 'required'],
            [['client_id', 'freelancer_id', 'category_id'], 'integer'],
            [['description', 'status', 'freelancer_response', 'freelancer_requisite'], 'string'],
            [['budget'], 'number'],
            [['deadline_date', 'deadline_time', 'created_at', 'updated_at'], 'safe'],
            [['title', 'file', 'final_file'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => array_keys($this->getStatus())], // Добавлено
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['freelancer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Freelancer::class, 'targetAttribute' => ['freelancer_id' => 'id']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'client_id' => Yii::t('app', 'Заказчик'),
            'freelancer_id' => Yii::t('app', 'Фрилансер'),
            'title' => Yii::t('app', 'Название'),
            'description' => Yii::t('app', 'Описание задания'),
            'budget' => Yii::t('app', 'Бюджет'),
            'freelancer_response' => Yii::t('app', 'Ответ фрилансера'),
            'freelancer_requisite' => Yii::t('app', 'Реквизиты фрилансера'),
            'file' => Yii::t('app', 'Исходный файл'),
            'final_file' => Yii::t('app', 'Готовое задание'),
            'deadline_date' => Yii::t('app', 'Дата завершение работы'),
            'deadline_time' => Yii::t('app', 'Время завершение работы'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
            'category_id' => Yii::t('app', 'Категория проекта'),
        ];
    }

    public static function getStatus(): array
    {
        return [
            'open' => 'Открыт',
            'in progress' => 'В процессе',
            'completed' => 'Завершен',
            'canceled' => 'Отменен',
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

    /**
     * Gets query for [[Applications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['project_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
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
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['project_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }
}
