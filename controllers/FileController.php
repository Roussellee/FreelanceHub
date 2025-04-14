<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class FileController extends Controller
{
    /**
     * @throws NotFoundHttpException
     */
    public function actionDownload($folder, $filename)
    {
        // Проверка авторизации
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('danger', 'Доступ запрещен, сначала авторизируйтесь!');
            return $this->redirect(['/site/login']);
        }

        // Определение пути к файлу на основе переданной папки
        $path = Yii::getAlias('@webroot/uploads/' . $folder . '/' . $filename);

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        }

        throw new NotFoundHttpException('Файл не найден (возможна ошибка)');
    }

    // Метод для удаления файла
    public function actionDeleteFile($folder, $filename)
    {
        $fullPath = Yii::getAlias('@webroot/uploads/' . $folder . '/' . $filename);
        if (file_exists($fullPath)) {
            unlink($fullPath); // Удаление файла
            return true; // Возвращаем true, если файл успешно удален
        }
        return false; // Возвращаем false, если файл не найден
    }
}
