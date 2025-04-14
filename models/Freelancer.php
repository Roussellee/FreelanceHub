<?php

namespace app\models;

use Yii;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "freelancer".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $skills
 * @property string|null $experience
 * @property float|null $hourly_rate
 * @property string|null $portfolio
 * @property int|null $availability
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Application[] $applications
 * @property Project[] $projects
 * @property User $user
 */
class Freelancer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'freelancer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'availability'], 'integer'],
            [['skills', 'experience'], 'string'],
            [['hourly_rate'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['portfolio'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['skills', 'experience'], 'filter', 'filter' => function($value) {
                return HtmlPurifier::process($value); // Очищаем ввод
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'skills' => 'Навыки',
            'experience' => 'Опыт работы',
            'hourly_rate' => 'Почасовая ставка (₽)',
            'portfolio' => 'Файл портфолио',
            'availability' => 'Готов к работе',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[Applications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['freelancer_id' => 'id']);
    }

    /**
     * Gets query for [[Projects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::class, ['freelancer_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
