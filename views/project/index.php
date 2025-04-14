<?php

use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = 'Проекты';
?>

<style>
    .single-line {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .multi-line {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3; /* Количество строк */
        overflow: hidden;
    }
</style>

<div class="d-sm-flex justify-content-sm-between">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role === 'client'): ?>
        <?= Html::a('Создать проект', ['/project/create'], ['class' => 'btn btn-primary mt-2']) ?>
    <?php endif; ?>

</div>

<div class="row">
    <?php foreach ($dataProvider->models as $project): ?>
        <div class="col-12 mt-3">
            <div class="card shadow-sm border" style="border: 1px solid #ddd; border-radius: 5px;">
                <div class="card-header p-3 bg-dark">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-9">
                            <h4 class="card-title mb-2 single-line">
                                <a href="<?= Url::toRoute(['/project/view', 'slug' => $project->slug]) ?>"
                                   class="nav-link">
                                    <?= Html::encode($project->title) ?>
                                </a>
                            </h4>
                            <a href="<?= Url::toRoute(['/project/view', 'slug' => $project->slug]) ?>"
                               class="nav-link card-text mb-2 multi-line">
                                <?= Markdown::process($project->description); ?>
                            </a>
                            <p class="mb-2">Категория: <?= Html::encode($project->category->name) ?></p>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 text-md-end mt-3 mt-sm-0 border-left border-1 border-black">
                            <h4 class="mb-2 text-success">Бюджет: <?= Html::encode($project->budget) ?> руб.</h4>
                            <p class="mb-2">Срок сдачи проекта: <?= Html::encode($project->deadline_date) ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-2 pt-2 bg-primary bg-opacity-75">
                    <div class="row justify-content-between">
                        <div class="col-12 col-md-5">
                            <p class="mb-2">
                                <a style="overflow-wrap: break-word;"
                                   href="<?= Url::toRoute(['/client/profile', 'username' => $project->client->user->username]) ?>"
                                   class="nav-link d-inline text-white">
                                    <?= Html::encode($project->client->contact_person) ?>
                                </a>
                            </p>
                        </div>
                        <div class="col-12 col-sm-7 d-md-flex gap-2 align-items-center justify-content-md-end flex-xs-column">
                            <p class="mb-1">Опубликовано: <?= Yii::$app->formatter->asDate($project->created_at) ?></p>
                            <?php if ($project->client_id == Yii::$app->user->id): ?>
                                <?= Html::a('Изменить', ['/project/update', 'slug' => $project->slug], ['class' => 'btn btn-warning btn-sm']) ?>
                                <?= Html::a('Удалить', ['/project/delete', 'slug' => $project->slug], [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Вы уверены, что хотите удалить этот проект?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="text-center mt-3 d-flex justify-content-center">
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
        'activePageCssClass' => ' active',
        'pageCssClass' => 'page-item',
        'nextPageCssClass' => 'page-item next-page-css',
        'prevPageCssClass' => 'page-item prev-page-css',
        'disabledPageCssClass' => 'page-link',
        'hideOnSinglePage' => true,
        'maxButtonCount' => 5,
        'linkOptions' => ['class' => 'page-link']
    ]); ?>
</div>
