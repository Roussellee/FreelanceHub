<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $project app\models\Project */
/* @var $applications app\models\Application[] */

$this->title = 'Заявки проекта ' . $project->title;
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
                <th>Название заявки</th>
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
                            <?= Html::a('Просмотреть заявку', ['application/view', 'slug' => $application->slug], ['class' => 'btn btn-primary btn-sm me-1 mb-1']) ?>
                            <?= Html::a('Вернутся к проекту', ['/project/view', 'slug' => $application->project->slug], ['class' => 'btn btn-warning btn-sm me-1 mb-1']) ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>