<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\HtmlPurifier;

class ApplicationForm extends Model
{
    public $title;
    public $description;
    public $status;
    public $reason_rejection;
    public $freelancer_id;
    public $project_id;

    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255, 'min' => 6, 'message' => 'Минимум 6 символов'],
            [['status'], 'in', 'range' => ['pending', 'approved', 'declined']],
            [['reason_rejection'], 'string'],
            [['project_id'], 'integer'],
        ];
    }

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


    public function create()
    {
        if ($this->validate()) {
            $application = new Application();
            $application->title = $this->title;
            $application->description = $this->description;
            $application->status = 'pending';
            $application->freelancer_id = $this->freelancer_id;
            $application->project_id = $this->project_id;
            $application->save();
            if ($application->save()) {
                return $application;
            } else {
                Yii::error('Ошибка сохранения заявки: ' . json_encode($application->getErrors()));
            }
        } else {
            Yii::error('Ошибка валидации: ' . json_encode($this->getErrors()));
        }

        if (!$application->save()) {
            Yii::error('Ошибка при сохранении заявки: ' . json_encode($application->getErrors()));
        }

        return null;
    }

    public function accept(Application $application)
    {
        // Проверяем, имеет ли пользователь доступ к заявке
        if (Yii::$app->user->identity->role === 'client' && $application->project->client_id === Yii::$app->user->identity->client->user_id) {
            // Изменяем статус заявки на 'approved'
            $application->status = 'approved';

            // Сохраняем статус заявки
            if ($application->save()) {
                // Обновляем проект, устанавливая freelancer_id
                $project = $application->project; // Получаем проект, связанный с заявкой
                $project->freelancer_id = $application->freelancer_id; // Устанавливаем freelancer_id из заявки
                $project->status = 'in progress';
                // Сохраняем изменения в проекте
                if ($project->save()) {
                    return true; // Успешно сохранили
                } else {
                    Yii::error('Ошибка при сохранении проекта: ' . json_encode($project->getErrors()));
                }
            } else {
                Yii::error('Ошибка при сохранении заявки: ' . json_encode($application->getErrors()));
            }
        }
        return false; // Если доступ запрещен или произошла ошибка
    }

    public function reject(Application $application)
    {
        // Проверяем, имеет ли пользователь доступ к заявке
        if (Yii::$app->user->identity->role === 'client' && $application->project->client_id === Yii::$app->user->identity->client->user_id) {
            if (Yii::$app->request->isPost) {
                // Получаем причину отказа
                $this->reason_rejection = Yii::$app->request->post('ApplicationForm')['reason_rejection']; // Убедитесь, что имя совпадает
                $application->status = 'declined';
                $application->reason_rejection = $this->reason_rejection; // Сохраняем причину отказа
                return $application->save(); // Сохраняем изменения в заявке
            }
        }
        return false; // Если доступ запрещен или произошла ошибка
    }

}