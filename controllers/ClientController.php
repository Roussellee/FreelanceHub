<?php

namespace app\controllers;

use app\models\Application;
use app\models\Project;
use Yii;
use app\models\Client;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;

class ClientController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['profile'], // Указываем действие, доступное всем
                        'allow' => true,
                        'roles' => ['?'], // Разрешаем доступ неаутентифицированным пользователям
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @throws ForbiddenHttpException
     */
    public function actionIndex(): string
    {
        // Проверка, является ли текущий пользователь клиентом
        if (Yii::$app->user->identity->role !== 'client') {
            throw new ForbiddenHttpException('У вас нет доступа к этой странице.');
        }

        // Получаем проекты, связанные с текущим клиентом
        $projects = Project::find()->where(['client_id' => Yii::$app->user->id])->all();

        // Получаем все заявки, связанные с проектами клиента
        $applications = Application::find()->where(['project_id' => array_column($projects, 'id')])->all();

        return $this->render('index', [
            'projects' => $projects,
            'applications' => $applications,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionProfile($username)
    {
        $client = Client::find()->joinWith('user')->where(['user.username' => $username])->one();
        if (!$client) {
            throw new NotFoundHttpException('Клиент не найден.');
        }

        return $this->render('profile', [
            'client' => $client,
        ]);
    }


    /**
     * @throws NotFoundHttpException
     */
    public function actionEdit()
    {
        $userId = Yii::$app->user->id;
        $client = Client::findOne(['user_id' => $userId]);

        if (!$client) {
            throw new NotFoundHttpException('Клиент не найден.');
        }

        if (Yii::$app->request->isPost) {
            if ($client->load(Yii::$app->request->post()) && $client->save()) {
                Yii::$app->session->setFlash('success', 'Данные клиента успешно обновлены.');
                return $this->redirect(['/client/profile', 'username' => Yii::$app->user->identity->username]);
            }
        }

        return $this->render('edit', [
            'model' => $client,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws ForbiddenHttpException
     */
    public function actionApplications($projectSlug)
    {
        $project = Project::find()->where(['']);

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
}