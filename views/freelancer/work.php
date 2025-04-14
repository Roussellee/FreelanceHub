<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $applications app\models\Application */
/* @var $projects app\models\Project */

$this->title = 'Мои заявки';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container client-index mt-4">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Название проекта</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($applications as $application): ?>
                <tr>
                    <td><?= Html::encode($application->title) ?></td>
                    <td><?= Html::encode($application->getStatusLabel()) ?></td>
                    <td>
                        <div class="d-flex flex-wrap">
                            <?= Html::a('Просмотреть', ['/application/view', 'slug' => $application->slug], ['class' => 'btn btn-primary btn-sm me-1 mb-1']) ?>
                            <?= Html::a('Удалить заявку', ['application/delete', 'slug' => $application->slug], [
                                'class' => 'btn btn-danger btn-sm mb-1',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить эту заявку?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <hr>
    <h1>Проекты в работе</h1>
    <div class="table-responsive mt-3">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Название проекта</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= Html::encode($project->title) ?></td>
                    <td><?= Html::encode($project->getStatusLabel()) ?></td>
                    <td>
                        <div class="d-flex flex-wrap">
                            <?= Html::a('Просмотреть', ['/project/view', 'slug' => $project->slug], ['class' => 'btn btn-primary btn-sm me-1 mb-1']) ?>
                            <?= Html::a('Завершить проект', ['/project/complete', 'slug' => $project->slug], ['class' => 'btn btn-warning btn-sm me-1 mb-1']) ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
