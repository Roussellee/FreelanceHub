<?php
//
//use app\models\Project;
//use yii\helpers\Html;
//use yii\helpers\Markdown;
//use yii\helpers\Url;
//
///**
// * @var $project Project
// */
//$this->title = $project->title;
//?>
<!---->
<!--<div class="container mt-4">-->
<!--    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start">-->
<!--        <h1 class="mb-3">--><?php //= Html::encode($this->title) ?><!--</h1>-->
<!--        --><?php //if (!Yii::$app->user->isGuest): ?>
<!--            --><?php //if ($project->freelancer_id == ($project->freelancer->id == Yii::$app->user->identity->freelancer->id)): ?>
<!--                --><?php //= Html::a('Завершить проект', ['/project/complete', 'slug' => $project->slug], ['class' => 'btn btn-primary me-2']) ?>
<!--            --><?php //endif; ?>
<!--        --><?php //endif; ?>
<!---->
<!--    </div>-->
<!---->
<!--    <h4>Задание</h4>-->
<!--    <div class="mb-3" style="overflow-wrap: break-word;">--><?php //= Markdown::process($project->description); ?><!--</div>-->
<!--    <hr>-->
<!--    <p><strong>Бюджет:</strong> --><?php //= Html::encode($project->budget) ?><!-- руб.</p>-->
<!--    <p><strong>Дата публикации:</strong> --><?php //= Html::encode($project->created_at) ?><!--</p>-->
<!--    <p><strong>Срок выполнения:</strong> --><?php //= Html::encode($project->deadline_date . ' ' . $project->deadline_time) ?>
<!--    </p>-->
<!--    <p><strong>Статус:</strong> --><?php //= Html::encode($project->getStatusLabel()) ?><!--</p>-->
<!---->
<!--    <div class="mt-2 mb-2">-->
<!--        --><?php //if ($project->file): ?>
<!--            --><?php //if (!Yii::$app->user->isGuest): ?>
<!--                <a class="btn btn-link"-->
<!--                   href="--><?php //= Url::to(['file/download', 'folder' => 'project', 'filename' => basename($project->file)]) ?><!--">Скачать-->
<!--                    файл из проекта</a>-->
<!--            --><?php //else: ?>
<!--                <p>Для загрузки файла нужно авторизоваться</p>-->
<!--            --><?php //endif; ?>
<!--        --><?php //endif; ?>
<!--        --><?php //if (!Yii::$app->user->isGuest && Yii::$app->user->identity->freelancer && empty($project->freelancer_id)): ?>
<!--            --><?php //= Html::a('Подать заявку на участие', ['/application/create', 'projectSlug' => $project->slug], ['class' => 'btn btn-primary me-2']) ?>
<!--        --><?php //endif; ?>
<!--    </div>-->
<!--    --><?php //if (!Yii::$app->user->isGuest): ?>
<!--        --><?php //if ($project->status == 'completed' && ($project->client->user_id === Yii::$app->user->identity->id || $project->freelancer->user_id === Yii::$app->user->identity->id)): ?>
<!--            --><?php //if ($project->freelancer_response): ?>
<!--                <hr>-->
<!--                <h3 class="mt-3 text-center text-danger">Выполненный проект</h3>-->
<!--                <p>Ответ фрилансера: --><?php //= Markdown::process($project->freelancer_response) ?><!--</p>-->
<!--            --><?php //endif; ?>
<!--            --><?php //if ($project->freelancer_requisite): ?>
<!--                <p>Реквизиты фрилансера: --><?php //= Markdown::process($project->freelancer_requisite) ?><!--</p>-->
<!--            --><?php //endif; ?>
<!--            --><?php //if ($project->final_file): ?>
<!--                <a class="btn btn-link"-->
<!--                   href="--><?php //= Url::to(['file/download', 'folder' => 'project', 'filename' => basename($project->final_file)]) ?><!--">Скачать-->
<!--                    завершенный файл проекта</a>-->
<!--            --><?php //endif; ?>
<!--        --><?php //endif; ?>
<!--    --><?php //endif; ?>
<!---->
<!--    <div class="mb-4">-->
<!--        --><?php //if (!Yii::$app->user->isGuest): ?>
<!--            --><?php //if ($project->client->user_id === Yii::$app->user->identity->id): ?>
<!--                --><?php //= Html::a('Заявки проекта', ['/project/applications', 'projectSlug' => $project->slug], ['class' => 'btn btn-primary btn-sm me-1 mb-1']) ?>
<!--                --><?php //= Html::a('Добавить задачу', ['task/create', 'projectSlug' => $project->slug], ['class' => 'btn btn-success btn-sm']) ?>
<!--                --><?php //= Html::a('Изменить', ['/project/update', 'slug' => $project->slug], ['class' => 'btn btn-warning btn-sm me-2']) ?>
<!--                --><?php //= Html::a('Удалить', ['/project/delete', 'slug' => $project->slug], [
//                    'class' => 'btn btn-danger btn-sm',
//                    'data' => [
//                        'confirm' => 'Вы уверены, что хотите удалить этот проект?',
//                        'method' => 'post',
//                    ],
//                ]) ?>
<!--            --><?php //endif; ?>
<!--        --><?php //endif; ?>
<!--    </div>-->
<!---->
<!--    --><?php //if ((!Yii::$app->user->isGuest) && ($project->freelancer->user_id == Yii::$app->user->id || $project->client->user_id == Yii::$app->user->id)): ?>
<!--        --><?php //if (!empty($project->freelancer_id)): ?>
<!--            <hr>-->
<!--            <h3>Данные фрилансера</h3>-->
<!--            <p>Логин: --><?php //= Html::a($project->freelancer->user->username, ['freelancer/profile', 'username' => $project->freelancer->user->username]) ?><!--</p>-->
<!--            <p><strong>Email:</strong> --><?php //= Html::encode($project->freelancer->user->email) ?><!--</p>-->
<!--            <hr>-->
<!--            <h3 class="mt-3">Данные заказчика</h3>-->
<!--            <p>Контактное лицо: --><?php //= Html::a($project->client->contact_person, ['client/profile', 'username' => $project->client->user->username]) ?><!--</p>-->
<!--            <p><strong>Email:</strong> --><?php //= Html::encode($project->client->user->email) ?><!--</p>-->
<!--            <p><strong>Номер для связи:</strong> --><?php //= Html::encode($project->client->phone) ?><!--</p>-->
<!--            <hr>-->
<!--        --><?php //endif; ?>
<!--    --><?php //endif; ?>
<!---->
<!---->
<!--    <h2 class="mt-4">Задачи проекта</h2>-->
<!--    --><?php //if (!empty($project->tasks)): ?>
<!--        <div class="table-responsive">-->
<!--            <table class="table table-striped">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th>Название</th>-->
<!--                    <th>Статус</th>-->
<!--                    --><?php //if ($project->client_id == Yii::$app->user->id): ?>
<!--                        <th>Действия</th>-->
<!--                    --><?php //endif; ?>
<!--                    --><?php //if ((!Yii::$app->user->isGuest) && ($project->freelancer->user_id == Yii::$app->user->id)): ?>
<!--                        <th>Действие</th>-->
<!--                    --><?php //endif; ?>
<!--                    <th>Файл</th>-->
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                --><?php //foreach ($project->tasks as $task): ?>
<!--                    <tr>-->
<!--                        <td style="overflow-wrap: break-word;">--><?php //= Html::a(Html::encode($task->title), ['task/view', 'projectSlug' => $project->slug, 'slug' => $task->slug],
//                                ['class' => ' text-decoration-none', 'style' => 'color: inherit']); ?><!--</td>-->
<!--                        <td style="overflow-wrap: break-word;">--><?php //= Html::encode($task->getStatusLabel()) ?><!--</td>-->
<!--                        --><?php //if ($project->client_id == Yii::$app->user->id): ?>
<!--                            <td>-->
<!--                                <div class="mb-4">-->
<!--                                    <div class="d-flex flex-column flex-sm-row">-->
<!--                                        --><?php //= Html::a('Просмотр', ['task/view', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'btn btn-primary btn-sm mb-2 mb-sm-0 me-sm-2']) ?>
<!--                                        --><?php //= Html::a('Изменить', ['task/update', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'btn btn-warning btn-sm mb-2 mb-sm-0 me-sm-2']) ?>
<!--                                        --><?php //= Html::a('Удалить', ['task/delete', 'projectSlug' => $project->slug, 'slug' => $task->slug], [
//                                            'class' => 'btn btn-danger btn-sm',
//                                            'data' => [
//                                                'confirm' => 'Вы уверены, что хотите удалить этот проект?',
//                                                'method' => 'post',
//                                            ],
//                                        ]) ?>
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                        --><?php //endif; ?>
<!--                        --><?php //if ((!Yii::$app->user->isGuest) && ($project->freelancer->user_id == Yii::$app->user->id)): ?>
<!--                            <td>-->
<!--                                <div class="mb-4">-->
<!--                                    <div class="d-flex flex-column flex-sm-row">-->
<!--                                        --><?php //= Html::a('Просмотр', ['task/view', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'btn btn-primary btn-sm mb-2 mb-sm-0 me-sm-2']) ?>
<!--                                        --><?php //if ($task->status == 'pending'): ?>
<!--                                            --><?php //= Html::a('Завершить', ['task/complete', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'btn btn-warning btn-sm mb-2 mb-sm-0 me-sm-2']) ?>
<!--                                        --><?php //endif; ?>
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                        --><?php //endif; ?>
<!--                        <td>-->
<!--                            --><?php //if ($task->file_task): ?>
<!--                                --><?php //= Html::a('Скачать файл', ['file/download', 'folder' => 'task', 'filename' => basename($task->file_task)], ['class' => 'btn btn-primary btn-sm me-1']) ?>
<!--                            --><?php //else: ?>
<!--                                <p>Файла нет</p>-->
<!--                            --><?php //endif; ?>
<!--                        </td>-->
<!--                    </tr>-->
<!--                --><?php //endforeach; ?>
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
<!--    --><?php //else: ?>
<!--        <h4 class="text-center">К сожалению, задач пока нет...</h4>-->
<!--    --><?php //endif; ?>
<!--</div>-->
<?php

use app\models\Project;
use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\helpers\Url;

/**
 * @var $project Project
 */
$this->title = $project->title;
?>

<div class="container mt-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start">
        <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php if (!empty($project->freelancer_id)): ?>
                <?= Html::a('Завершить проект', ['/project/complete', 'slug' => $project->slug], ['class' => 'btn btn-primary me-2']) ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <h4>Задание</h4>
    <div class="mb-3" style="overflow-wrap: break-word;"><?= Markdown::process($project->description); ?></div>
    <hr>
    <p><strong>Бюджет:</strong> <?= Html::encode($project->budget) ?> руб.</p>
    <p><strong>Дата публикации:</strong> <?= Html::encode($project->created_at) ?></p>
    <p><strong>Срок выполнения:</strong> <?= Html::encode($project->deadline_date . ' ' . $project->deadline_time) ?></p>
    <p><strong>Статус:</strong> <?= Html::encode($project->getStatusLabel()) ?></p>

    <div class="mt-2 mb-2">
        <?php if ($project->file): ?>
            <?php if (!Yii::$app->user->isGuest): ?>
                <a class="btn btn-link" href="<?= Url::to(['file/download', 'folder' => 'project', 'filename' => basename($project->file)]) ?>">Скачать файл из проекта</a>
            <?php else: ?>
                <p>Для загрузки файла нужно авторизоваться</p>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->freelancer && empty($project->freelancer_id)): ?>
            <?= Html::a('Подать заявку на участие', ['/application/create', 'projectSlug' => $project->slug], ['class' => 'btn btn-primary me-2']) ?>
        <?php endif; ?>
    </div>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?php if ($project->status === 'completed' && ($project->client->user_id === Yii::$app->user->identity->id || ($project->freelancer && $project->freelancer->user_id === Yii::$app->user->identity->id))): ?>
            <?php if ($project->freelancer_response): ?>
                <hr>
                <h3 class="mt-3 text-center text-danger">Выполненный проект</h3>
                <p>Ответ фрилансера: <?= Markdown::process($project->freelancer_response) ?></p>
            <?php endif; ?>
            <?php if ($project->freelancer_requisite): ?>
                <p>Реквизиты фрилансера: <?= Markdown::process($project->freelancer_requisite) ?></p>
            <?php endif; ?>
            <?php if ($project->final_file): ?>
                <a class="btn btn-link" href="<?= Url::to(['file/download', 'folder' => 'project', 'filename' => basename($project->final_file)]) ?>">Скачать завершенный файл проекта</a>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <div class="mb-4">
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php if ($project->client->user_id === Yii::$app->user->identity->id): ?>
                <?= Html::a('Заявки проекта', ['/project/applications', 'projectSlug' => $project->slug], ['class' => 'btn btn-primary btn-sm me-1 mb-1']) ?>
                <?= Html::a('Добавить задачу', ['task/create', 'projectSlug' => $project->slug], ['class' => 'btn btn-success btn-sm']) ?>
                <?= Html::a('Изменить', ['/project/update', 'slug' => $project->slug], ['class' => 'btn btn-warning btn-sm me-2']) ?>
                <?= Html::a('Удалить', ['/project/delete', 'slug' => $project->slug], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить этот проект?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

<?php if (!Yii::$app->user->isGuest && ($project->freelancer && $project->freelancer->user_id == Yii::$app->user->id || $project->client->user_id == Yii::$app->user->id)): ?>
    <?php if (!empty($project->freelancer_id)): ?>
        <hr>
        <h3>Данные фрилансера</h3>
        <p>Логин: <?= Html::a($project->freelancer->user->username, ['freelancer/profile', 'username' => $project->freelancer->user->username]) ?></p>
        <p><strong>Email:</strong> <?= Html::encode($project->freelancer->user->email) ?></p>
        <hr>
        <h3 class="mt-3">Данные заказчика</h3>
        <p>Контактное лицо: <?= Html::a($project->client->contact_person, ['client/profile', 'username' => $project->client->user->username]) ?></p>
        <p><strong>Email:</strong> <?= Html::encode($project->client->user->email) ?></p>
        <p><strong>Номер для связи:</strong> <?= Html::encode($project->client->phone) ?></p>
        <hr>
    <?php endif; ?>
<?php endif; ?>

    <h2 class="mt-4">Задачи проекта</h2>
<?php if (!empty($project->tasks)): ?>
    <div class="table-responsive">
    <table class="table table-striped">
    <thead>
    <tr>
        <th>Название</th>
        <th>Статус</th>
        <?php if ($project->client_id == Yii::$app->user->id): ?>
            <th>Действия</th>
        <?php endif; ?>
        <?php if (!Yii::$app->user->isGuest && $project->freelancer && $project->freelancer->user_id == Yii::$app->user->id): ?>
            <th>Действие</th>
        <?php endif; ?>
        <th>Файл</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($project->tasks as $task): ?>
        <tr>
        <td style="overflow-wrap: break-word;"><?= Html::a(Html::encode($task->title), ['task/view', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'text-decoration-none', 'style' => 'color: inherit']); ?></td>
        <td style="overflow-wrap: break-word;"><?= Html::encode($task->getStatusLabel()) ?></td>
        <?php if ($project->client_id == Yii::$app->user->id): ?>
            <td>
            <div class="mb-4">
            <div class="d-flex flex-column flex-sm-row">
            <?= Html::a('Просмотр', ['task/view', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'btn btn-primary btn-sm mb-2 mb-sm-0 me-sm-2']) ?>
            <?= Html::a('Изменить', ['task/update', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'btn btn-warning btn-sm mb-2 mb-sm-0 me-sm-2']) ?>
            <?= Html::a('Удалить', ['task/delete', 'projectSlug' => $project->slug, 'slug' => $task->slug], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить этот проект?',
                    'method' => 'post',
                ],
            ]) ?>
            </div>
            </div>
            </td>
        <?php endif; ?>
            <?php if (!Yii::$app->user->isGuest && $project->freelancer && $project->freelancer->user_id == Yii::$app->user->id): ?>
                <td>
                    <div class="mb-4">
                        <div class="d-flex flex-column flex-sm-row">
                            <?= Html::a('Просмотр', ['task/view', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'btn btn-primary btn-sm mb-2 mb-sm-0 me-sm-2']) ?>
                            <?php if ($task->status == 'pending'): ?>
                                <?= Html::a('Завершить', ['task/complete', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'btn btn-warning btn-sm mb-2 mb-sm-0 me-sm-2']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            <?php endif; ?>
            <td>
                <?php if ($task->file_task): ?>
                    <?= Html::a('Скачать файл', ['file/download', 'folder' => 'task', 'filename' => basename($task->file_task)], ['class' => 'btn btn-primary btn-sm me-1']) ?>
                <?php else: ?>
                    <p>Файла нет</p>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
<?php else: ?>
    <h4 class="text-center">К сожалению, задач пока нет...</h4>
<?php endif; ?>
</div>