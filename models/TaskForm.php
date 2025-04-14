<?php

namespace app\models;

use app\controllers\FileController;
use Yii;
use yii\base\Model;
use yii\helpers\HtmlPurifier;
use yii\web\UploadedFile;

class TaskForm extends Model
{
    public $title;
    public $description;
    public $status;
    public $freelancer_response;
    public $file_task; // Файл от заказчика
    public $upload_file; // Файл от фрилансера
    public $project_id;

    public function rules()
    {
        return [
            [['title', 'description', 'project_id'], 'required'],
            [['status'], 'in', 'range' => array_keys(Task::getStatus())],
            [['file_task'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, pdf, txt, rar, 7z, doc, docx',
                'maxSize' => 256 * 1024 * 1024, // 256 MB
                'tooBig' => 'Файл слишком большой. Максимальный размер файла: 256 MB.'
            ],
            [['upload_file'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, pdf, txt, rar, 7z, doc, docx',
                'maxSize' => 256 * 1024 * 1024, // 256 MB
                'tooBig' => 'Файл слишком большой. Максимальный размер файла: 256 MB.'
            ],
//            [['file_task'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf, txt, rar, 7z, doc, docx'],
//            [['upload_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf, txt, rar, 7z, doc, docx'],
            [['title'], 'string', 'max' => 255, 'min' => 6],
            [['description', 'freelancer_response'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Проект'),
            'title' => Yii::t('app', 'Название задачи'),
            'description' => Yii::t('app', 'Описание задачи'),
            'status' => Yii::t('app', 'Статус'),
            'freelancer_response' => Yii::t('app','Ответ фрилансера'),
            'file_task' => Yii::t('app', 'Файл задачи'),
            'upload_file' => Yii::t('app', 'Загрузить файл от фрилансера'),
        ];
    }

    public function save()
    {
        if ($this->validate()) {
            $task = new Task();
            $task->title = $this->title;
            $task->description = HtmlPurifier::process($this->description);
            $task->project_id = $this->project_id;

            // Сохраняем файл с уникальным именем в указанную папку
            if ($this->file_task instanceof UploadedFile) {
                $filePath = 'task_' . uniqid('', true) . '.' . $this->file_task->extension;
                if ($this->file_task->saveAs(Yii::getAlias('@webroot/uploads/task/') . $filePath)) {
                    $task->file_task = $filePath; // Сохраняем путь к файлу
                } else {
                    $this->addError('file_task', 'Не удалось загрузить файл.');
                    return null; // Возвращаем null, если не удалось сохранить файл
                }
            }

            return $task->save() ? $task : null;
        }
        return false;
    }

    public function update($taskId)
    {
        $task = Task::findOne($taskId);
        if ($task) {
            $task->title = $this->title;
            $task->description = HtmlPurifier::process($this->description);
            $task->status = $this->status;
            // Проверка на очистку файла
            if (Yii::$app->request->post('clear_file')) {
                if ($task->file_task) {
                    // Вызов метода удаления файла из FileController
                    $fileController = new FileController('file', Yii::$app);
                    $fileController->actionDeleteFile('task', $task->file_task);
                }
                $task->file_task = null; // Очистка поля
            }

            // Сохранение нового файла, если он был загружен
            if ($this->file_task instanceof UploadedFile) {
                // Удаление старого файла, если он существует
                if ($task->file_task) {
                    // Вызов метода удаления файла из FileController
                    $fileController = new FileController('file', Yii::$app);
                    $fileController->actionDeleteFile('task', $task->file_task);
                }
                $filePath = 'task_' . uniqid('', true) . '.' . $this->file_task->extension;
                if ($this->file_task->saveAs(Yii::getAlias('@webroot/uploads/task/') . $filePath)) {
                    $task->file_task = $filePath; // Сохраняем путь к новому файлу
                } else {
                    $this->addError('file_task', 'Не удалось загрузить файл.');
                    return null; // Возвращаем null, если не удалось сохранить файл
                }
            }

            return $task->save() ? $task : null;
        }
        return false;
    }

    public function complete($taskId)
    {
        $task = Task::findOne($taskId);
        if ($task) {
            $task->freelancer_response = HtmlPurifier::process($this->freelancer_response);
            $task->upload_file = $this->upload_file ? $this->upload_file : null; // Если файл загружен, сохраняем его
            $task->status = 'completed'; // Устанавливаем статус как 'completed'

            // Сохраняем файл с уникальным именем в указанную папку
            if ($this->upload_file instanceof UploadedFile) {
                $filePath = 'upload_' . uniqid('', true) . '.' . $this->upload_file->extension;
                if ($this->upload_file->saveAs(Yii::getAlias('@webroot/uploads/task/') . $filePath)) {
                    $task->upload_file = $filePath; // Сохраняем путь к файлу
                } else {
                    $this->addError('upload_file', 'Не удалось загрузить файл.');
                    return null; // Возвращаем null, если не удалось сохранить файл
                }
            }

            return $task->save() ? $task : null;
        }
        return false;
    }
}
