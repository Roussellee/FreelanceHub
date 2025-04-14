<?php

namespace app\controllers;

use app\models\Application;
use app\models\Project;
use Yii;
use app\models\Freelancer;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;

class FreelancerController extends Controller  //  <<<=== ИЗМЕНЕНИЕ ЗДЕСЬ
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
                        'roles' => ['@'], // Разрешаем доступ только аутентифицированным пользователям
                    ],
                ],
            ],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionWork()
    {

        $freelancer = Freelancer::findOne(['user_id' => Yii::$app->user->id]);
        $applications = Application::find()->where(['freelancer_id' => $freelancer])->all();
        $projects = Project::find()->where(['freelancer_id' => $freelancer])->all();

        if (!$applications) {
            throw new NotFoundHttpException('Заявки не найдены.');
        }

        return $this->render('work', [
            'applications' => $applications,
            'projects' => $projects,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionProfile($username)
    {
        $freelancer = Freelancer::find()->joinWith('user')->where(['user.username' => $username])->one();
        if (!$freelancer) {
            throw new NotFoundHttpException('Фрилансер не найден.');
        }

        return $this->render('profile', [
            'model' => $freelancer,
        ]);
    }


    /**
     * @throws NotFoundHttpException
     */
    public function actionEdit()
    {
        $userId = Yii::$app->user->id;
        $freelancer = Freelancer::findOne(['user_id' => $userId]);

        if (!$freelancer) {
            throw new NotFoundHttpException('Фрилансер не найден.');
        }

        if (Yii::$app->request->isPost) {
            if ($freelancer->load(Yii::$app->request->post()) && $freelancer->save()) {
                Yii::$app->session->setFlash('success', 'Данные фрилансера успешно обновлены.');
                return $this->redirect(['/freelancer/profile', 'username' => Yii::$app->user->identity->username]);
            }
        }

        return $this->render('edit', [
            'model' => $freelancer,
        ]);
    }
}