<?php

namespace app\controllers;

use app\models\Application;
use app\models\Category;
use app\models\Task;
use Yii;
use app\models\ProjectForm;
use app\models\Project;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProjectController extends Controller
{
    public function actionIndex()
    {
        $query = Project::find()->with('category')->where(['status' => 'open']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($slug)
    {
        $project = $this->findModelBySlug($slug);
        return $this->render('view', ['project' => $project]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionApplications($projectSlug)
    {
        $project = $this->findModelBySlug($projectSlug);

        // Проверка доступа: только клиент, создавший проект
        if ($project->client_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        }

        // Получаем все заявки, связанные с проектом
        $applications = Application::find()->where(['project_id' => $project->id])->all();

        return $this->render('applications', [
            'project' => $project,
            'applications' => $applications,
        ]);
    }

    /**
     * @throws ForbiddenHttpException
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->role !== 'client') {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        }

        $model = new ProjectForm();
        $categories = Category::find()->select(['name', 'id'])->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post())) {
            $model->client_id = Yii::$app->user->id;
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Вы успешно создали проект!');
                return $this->redirect(['/client/index']);
            }
        }

        return $this->render('create', ['model' => $model, 'categories' => $categories]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($slug)
    {
        $project = $this->findModelBySlug($slug);
        // Проверка доступа
        if ($project->client_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('У вас нет доступа для обновления этого проекта');
        }

        $model = new ProjectForm();
        $model->setAttributes($project->getAttributes());
        $categories = Category::find()->select(['name', 'id'])->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');

            // Если статус не изменен, оставляем его прежним
            if (empty($model->status)) {
                $model->status = $project->status;
            }

            if ($model->update($project->id)) {
                Yii::$app->session->setFlash('success', 'Задача успешно обновлена.');
                return $this->redirect(['project/view', 'slug' => $project->slug]);
            }
        }

        // Передаем массив статусов и текущий статус в представление
        return $this->render('update', [
            'model' => $model,
            'currentFile' => $project->file,
            'project' => $project,
            'categories' => $categories,
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
        $project = $this->findModelBySlug($slug);
        // Проверяем, имеет ли пользователь доступ к проекту
        if ($project->client_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('У вас нет доступа к удалению этого проекта.');
        }
        // Удаляем файл из файловой системы
        if ($project->file) {
            // Вызов метода удаления файла из FileController
            $fileController = new FileController('file', Yii::$app);
            $fileController->actionDeleteFile('project', $project->file);
        }
        if ($project->final_file) {
            // Вызов метода удаления файла из FileController
            $fileController = new FileController('file', Yii::$app);
            $fileController->actionDeleteFile('project', $project->file);
        }
        foreach ($project->tasks as $task) {
            if ($task->file_task) {
                $fileController = new FileController('file', Yii::$app);
                $fileController->actionDeleteFile('task', $task->file_task); // Удаляем файл задачи
            }
            if ($task->upload_file) {
                $fileController = new FileController('file', Yii::$app);
                $fileController->actionDeleteFile('task', $task->upload_file); // Удаляем файл задачи
            }
            $task->delete(); // Удаляем задачу
        }
        // Удаляем проект
        if ($project->delete()) {
            Yii::$app->session->setFlash('success', 'Вы успешно удалили проект и связанные задачи!');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при удалении проекта.'); // Обработка ошибок
        }

        return $this->redirect(['/client/index']); // Перенаправление на проект
    }


    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionComplete($slug)
    {
        $project = $this->findModelBySlug($slug);

        // Проверяем, имеет ли пользователь доступ к выполнению задачи
        if ($project->freelancer_id !== Yii::$app->user->identity->freelancer->id) {
            throw new ForbiddenHttpException('У вас нет доступа к выполнению этой задачи.');
        }

        $model = new ProjectForm();
//        $model->project_id = $task->project_id; // Устанавливаем project_id

        if ($model->load(Yii::$app->request->post())) {
            $model->final_file = UploadedFile::getInstance($model, 'final_file'); // Получаем загружаемый файл
            if ($model->complete($project->id)) {
                Yii::$app->session->setFlash('success', 'Вы успешно завершили задачу.');
                return $this->redirect(['project/view', 'slug' => $project->slug]); // Перенаправление на проект
            } else {
                Yii::debug($model->getErrors(), __METHOD__);
                Yii::$app->session->setFlash('danger', 'Ошибка при завершении задачи: ' . implode(', ', $model->getFirstErrors()));
            }
        }

        return $this->render('complete', [
            'model' => $model,
            'project' => $project,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModelBySlug($slug)
    {
        if (($model = Project::findOne(['slug' => $slug])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

