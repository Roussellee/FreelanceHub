<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $project_id
 * @property int $reviewer_id
 * @property int $reviewee_id
 * @property int $rating
 * @property string|null $comment
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Project $project
 * @property User $reviewee
 * @property User $reviewer
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'reviewer_id', 'reviewee_id'], 'required'],
            [['project_id', 'reviewer_id', 'reviewee_id', 'rating'], 'integer'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
            [['reviewee_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['reviewee_id' => 'id']],
            [['reviewer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['reviewer_id' => 'id']],
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
            'reviewer_id' => Yii::t('app', 'Reviewer ID'),
            'reviewee_id' => Yii::t('app', 'Reviewee ID'),
            'rating' => Yii::t('app', 'Rating'),
            'comment' => Yii::t('app', 'Comment'),
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

    /**
     * Gets query for [[Reviewee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviewee()
    {
        return $this->hasOne(User::class, ['id' => 'reviewee_id']);
    }

    /**
     * Gets query for [[Reviewer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviewer()
    {
        return $this->hasOne(User::class, ['id' => 'reviewer_id']);
    }
}
