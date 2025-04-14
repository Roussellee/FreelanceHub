<?php

namespace app\models;

use app\controllers\FileController;
use Yii;
use yii\base\Model;
use yii\helpers\HtmlPurifier;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

class ProjectForm extends Model
{
    public $title;
    public $description;
    public $budget;
    public $file;
    public $final_file;
    public $deadline_date;
    public $deadline_time;
    public $category_id;
    public $client_id;
    public $status;
    public $freelancer_response;
    public $freelancer_requisite;

// TODO: Сделать update и загрузку файлов

    public function rules()
    {
        return [
            [['title', 'description', 'budget', 'deadline_date', 'deadline_time', 'category_id', 'client_id'], 'required'],
            [['budget'], 'number'],
            [['file'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, pdf, txt, rar, 7z, doc, docx',
                'maxSize' => 256 * 1024 * 1024, // 256 MB
                'tooBig' => 'Файл слишком большой. Максимальный размер файла: 256 MB.'
            ],
            [['final_file'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, pdf, txt, rar, 7z, doc, docx',
                'maxSize' => 256 * 1024 * 1024, // 256 MB
                'tooBig' => 'Файл слишком большой. Максимальный размер файла: 256 MB.'
            ],
            [['freelancer_response', 'freelancer_requisite'], 'string'],
            [['deadline_date'], 'date', 'format' => 'php:Y-m-d'],
            [['deadline_time'], 'string', 'max' => 8], // HH:MM
            [['status'], 'in', 'range' => ['open', 'in progress', 'completed', 'canceled'], 'message' => 'Некорректный статус.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание требуемого задания',
            'budget' => 'Бюджет',
            'file' => 'Исходный файл проекта (не обязательное)',
            'final_file' => 'Финальный файл',
            'deadline_date' => 'Дата сдачи',
            'deadline_time' => 'Время сдачи',
            'category_id' => 'Категория',
            'status' => 'Статус проекта',
            'freelancer_response' => 'Ответ фрилансера',
            'freelancer_requisite' => 'Реквизиты фрилансера',
        ];
    }


    public function upload()
    {
        if ($this->validate()) {
            if ($this->file) {
                $filePath = 'uploads/project/';
                $fileName = uniqid('project_', true) . '.' . $this->file->extension; // Уникальное имя файла
                $this->file->saveAs($filePath . $fileName);
                return $fileName; // Возвращаем имя файла
            }
            if ($this->final_file) {
                $finalFilePath = 'uploads/project/';
                $finalFileName = uniqid('final_', true) . '.' . $this->final_file->extension; // Уникальное имя файла
                $this->final_file->saveAs($finalFilePath . $finalFileName);
                return $finalFileName;
            }
        }
        return null;
    }

    public function save()
    {
        if ($this->validate()) {
            $project = new Project();
            $project->title = $this->title;
            $project->description = HtmlPurifier::process($this->description);
            $project->budget = $this->budget;
            $project->client_id = $this->client_id;

            $project->file = $this->upload();

            $project->deadline_date = $this->deadline_date;
            $project->deadline_time = $this->deadline_time;
            $project->category_id = $this->category_id;

            return $project->save() ? $project : null;
        }
        return false;
    }

    public function update($projectId)
    {
        $project = Project::findOne($projectId);
        if ($project) {
            $project->title = $this->title;
            $project->description = HtmlPurifier::process($this->description);
            $project->budget = $this->budget;
            $project->deadline_date = $this->deadline_date;
            $project->deadline_time = $this->deadline_time;
            $project->category_id = $this->category_id;
            $project->status = $this->status;

            // Проверка на очистку файла
            if (Yii::$app->request->post('clear_file')) {
                if ($project->file) {
                    // Вызов метода удаления файла из FileController
                    $fileController = new FileController('file', Yii::$app);
                    $fileController->actionDeleteFile('project', $project->file);
                }
                $project->file = null; // Очистка поля
            }

            // Сохранение нового файла, если он был загружен
            if ($this->file instanceof UploadedFile) {
                // Удаление старого файла, если он существует
                if ($project->file) {
                    // Вызов метода удаления файла из FileController
                    $fileController = new FileController('file', Yii::$app);
                    $fileController->actionDeleteFile('project', $project->file);
                }
                $filePath = 'project_' . uniqid('', true) . '.' . $this->file->extension;
                if ($this->file->saveAs(Yii::getAlias('@webroot/uploads/project/') . $filePath)) {
                    $project->file = $filePath; // Сохраняем путь к новому файлу
                } else {
                    $this->addError('file', 'Не удалось загрузить файл.');
                    return null; // Возвращаем null, если не удалось сохранить файл
                }
            }

            return $project->save() ? $project : null;
        }
        return false;
    }

    public function complete($projectId)
    {
        $project = Project::findOne($projectId);
        if ($project) {
            $project->freelancer_response = HtmlPurifier::process($this->freelancer_response);
            $project->freelancer_requisite = HtmlPurifier::process($this->freelancer_requisite);
            $project->final_file = $this->final_file ? $this->final_file : null; // Если файл загружен, сохраняем его
            $project->status = 'completed'; // Устанавливаем статус как 'completed'

            // Сохраняем файл с уникальным именем в указанную папку
            if ($this->final_file instanceof UploadedFile) {
                $filePath = 'final_' . uniqid('', true) . '.' . $this->final_file->extension;
                if ($this->final_file->saveAs(Yii::getAlias('@webroot/uploads/project/') . $filePath)) {
                    $project->final_file = $filePath; // Сохраняем путь к файлу
                } else {
                    $this->addError('final_file', 'Не удалось загрузить файл.');
                    return null; // Возвращаем null, если не удалось сохранить файл
                }
            }

            return $project->save() ? $project : null;
        }
        return false;
    }

}
