<?php

namespace app\controllers;

use app\models\Application;
use app\models\Client;
use app\models\Freelancer;
use app\models\Project;
use app\models\ApplicationForm;
use Yii;
use yii\helpers\HtmlPurifier;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class ApplicationController extends Controller
{

    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionView($slug)
    {
        // Найти заявку по slug
        $application = Application::findOne(['slug' => $slug]);
        if (!$application) {
            throw new NotFoundHttpException('Заявка не найдена.');
        }
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('warning', 'Для выполнения этого действия нужно авторизоваться');
            return $this->redirect(['/login']);
        }
        // Получить текущего пользователя
        $currentUser = Yii::$app->user->identity;
        // Проверка, является ли текущий пользователь фрилансером
        $isFreelancer = $currentUser->role === 'freelancer' && $application->freelancer_id == $currentUser->freelancer->id;
        // Проверка, является ли текущий пользователь клиентом
        $isClient = $currentUser->role === 'client' && $application->project->client_id == $currentUser->client->user_id;
        if (!$isFreelancer && !$isClient) {
            throw new ForbiddenHttpException('У вас нет доступа к этой заявке.');
        }
        // Если доступ разрешен, передаем данные в представление
        return $this->render('view', [
            'application' => $application,
        ]);
    }


    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionCreate($projectSlug)
    {
        if (!Yii::$app->user->identity->role == 'freelancer') {
            throw new ForbiddenHttpException('У вас нет доступа к созданию заявки.');
        }

        $model = new ApplicationForm();

        // Найти проект по slug
        $project = Project::findOne(['slug' => $projectSlug]);

        if (!$project) {
            throw new \yii\web\NotFoundHttpException('Проект не найден.');
        }
        $freelancer = Freelancer::findOne(['user_id' => Yii::$app->user->id]); // Получаем ID текущего пользователя
        $model->freelancer_id = $freelancer->id;
        $model->project_id = $project->id;
        if ($model->load(Yii::$app->request->post())) {
            Yii::info('Данные формы: ' . json_encode($model->attributes));
            if ($model->create()) {
                Yii::$app->session->setFlash('success', 'Заявка успешно создана.');
                return $this->redirect(['project/view', 'slug' => $projectSlug]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'project' => $project, // Передаем проект в представление, если нужно
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionAccept($slug)
    {
        $application = Application::findOne(['slug' => $slug]);
        if (!$application) {
            throw new NotFoundHttpException('Заявка не найдена.');
        }

        $model = new ApplicationForm();
        if ($model->accept($application)) {
            Yii::$app->session->setFlash('success', 'Заявка успешно принята.');
            return $this->redirect(['project/view', 'slug' => $application->project->slug]);
        } else {
            Yii::$app->session->setFlash('error', 'У вас нет доступа к этой заявке.');
            throw new ForbiddenHttpException('У вас нет доступа к этой заявке.');
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionReject($slug)
    {
        $application = Application::findOne(['slug' => $slug]);
        if (!$application) {
            throw new NotFoundHttpException('Заявка не найдена.');
        }

        $model = new ApplicationForm();
        if ($model->reject($application)) {
            Yii::$app->session->setFlash('success', 'Заявка успешно отклонена. Причина: ' . HtmlPurifier::process($model->reason_rejection));
            return $this->redirect(['project/view', 'slug' => $application->project->slug]);
        } else {
            Yii::$app->session->setFlash('error', 'У вас нет доступа к этой заявке или произошла ошибка.');
            return $this->redirect(['application/view', 'slug' => $application->slug]);
        }
    }

    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionDelete($slug)
    {
        // Найти заявку по slug
        $application = Application::findOne(['slug' => $slug]);
        if (!$application) {
            throw new NotFoundHttpException('Заявка не найдена.');
        }

        // Получаем текущего пользователя
        $currentUser  = Yii::$app->user->identity;

        // Проверка, является ли текущий пользователь фрилансером и соответствует ли ID фрилансера в заявке
        if ($currentUser->role !== 'freelancer' || $application->freelancer_id != $currentUser->freelancer->id) {
            throw new ForbiddenHttpException('У вас нет доступа к удалению этой заявки.');
        }

        // Удаляем заявку
        if ($application->delete()) {
            Yii::$app->session->setFlash('success', 'Заявка успешно удалена.');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при удалении заявки.');
        }

        // Перенаправляем на страницу проекта или другую страницу
        return $this->redirect(['freelancer/application']);
    }



    /**
     * @throws NotFoundHttpException
     */
    protected function findModelBySlug($slug): ?Project
    {
        if (($model = Project::findOne(['slug' => $slug])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Проект не найден.');
    }
}
