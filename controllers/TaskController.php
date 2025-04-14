<?php

namespace app\controllers;

use app\models\Project;
use Yii;
use app\models\TaskForm;
use app\models\Task;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TaskController extends Controller
{
    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionView($projectSlug, $slug)
    {
        $task = Task::findOne(['slug' => $slug]);

        if ($task === null) {
            throw new NotFoundHttpException('Задача не найдена.');
        }

        // Здесь можно добавить проверку на существование проекта
        $project = Project::findOne(['slug' => $projectSlug]);
        if ($project === null) {
            throw new NotFoundHttpException('Проект не найден.');
        }

        if (Yii::$app->user->isGuest) {
            return new ForbiddenHttpException('У вас нет доступа к просмотру задачи для этого проекта.');
        }
        

        return $this->render('view', [
            'task' => $task,
            'project' => $project,
        ]);
    }

    /**
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionCreate($projectSlug)
    {
        $project = Project::findOne(['slug' => $projectSlug]);

        if ($project === null) {
            throw new NotFoundHttpException('Проект не найден.');
        }

        // Проверяем, имеет ли пользователь доступ к проекту
        if ($project->client_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('У вас нет доступа к созданию задачи для этого проекта.');
        }

        $model = new TaskForm();
        $model->project_id = $project->id; // Устанавливаем project_id

        if ($model->load(Yii::$app->request->post())) {
            $model->file_task = UploadedFile::getInstance($model, 'file_task'); // Получаем загружаемый файл
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Вы успешно создали задачу для проекта');
                return $this->redirect(['project/view', 'slug' => $projectSlug]); // Перенаправление на проект
            } else {
                Yii::debug($model->getErrors(), __METHOD__);
                Yii::$app->session->setFlash('danger', 'Ошибка при создании задачи: ' . implode(', ', $model->getFirstErrors()));
                return $this->render('create', ['model' => $model]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($slug)
    {
        $task = $this->findModelBySlug($slug);
        $project = $task->project;

        // Проверка доступа
        if ($project->client_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('У вас нет доступа к обновлению задачи для этого проекта.');
        }

        $model = new TaskForm();
        $model->setAttributes($task->getAttributes());

        if ($model->load(Yii::$app->request->post())) {
            $model->file_task = UploadedFile::getInstance($model, 'file_task');
            if ($model->update($task->id)) {
                Yii::$app->session->setFlash('success', 'Задача успешно обновлена.');
                return $this->redirect(['project/view', 'slug' => $project->slug]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'statuses' => Task::getStatus(),
            'currentFile' => $task->file_task, // Передаем текущий файл в представление
            'project' => $project, // Передаем проект для ссылки
        ]);
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionDelete($slug)
    {
        $task = $this->findModelBySlug($slug);
        $project = $task->project;

        // Проверяем, имеет ли пользователь доступ к проекту
        if ($project->client_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('У вас нет доступа к удалению задачи для этого проекта.');
        }

        // Удаляем файл из файловой системы
        if ($task->file_task) {
            // Вызов метода удаления файла из FileController
            $fileController = new FileController('file', Yii::$app);
            $fileController->actionDeleteFile('task', $task->file_task);
        }

        if ($task->upload_file) {
            // Вызов метода удаления файла из FileController
            $fileController = new FileController('file', Yii::$app);
            $fileController->actionDeleteFile('task', $task->upload_file);
        }

        $projectSlug = $task->project->slug;
        $task->delete();
        Yii::$app->session->setFlash('success', 'Вы успешно удалили задачу проекта');
        return $this->redirect(['project/view', 'slug' => $projectSlug]); // Перенаправление на проект
    }

    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionComplete($slug)
    {
        $task = $this->findModelBySlug($slug);

        // Проверяем, имеет ли пользователь доступ к выполнению задачи
        if ($task->project->freelancer_id !== Yii::$app->user->identity->freelancer->id) {
            throw new ForbiddenHttpException('У вас нет доступа к выполнению этой задачи.');
        }

        $model = new TaskForm();
        $model->project_id = $task->project_id; // Устанавливаем project_id

        if ($model->load(Yii::$app->request->post())) {
            $model->upload_file = UploadedFile::getInstance($model, 'upload_file'); // Получаем загружаемый файл
            if ($model->complete($task->id)) {
                Yii::$app->session->setFlash('success', 'Вы успешно завершили задачу.');
                return $this->redirect(['project/view', 'slug' => $task->project->slug]); // Перенаправление на проект
            } else {
                Yii::debug($model->getErrors(), __METHOD__);
                Yii::$app->session->setFlash('danger', 'Ошибка при завершении задачи: ' . implode(', ', $model->getFirstErrors()));
            }
        }

        return $this->render('complete', [
            'model' => $model,
            'task' => $task,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModelBySlug($slug): ?Task
    {
        if (($model = Task::findOne(['slug' => $slug])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}


