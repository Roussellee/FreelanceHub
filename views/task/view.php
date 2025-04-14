<?php

use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\helpers\Url;

/* @var $task app\models\Task */
$this->title = 'Задача ' . $task->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <strong>Описание:</strong> <?= Markdown::process($task->description); ?><br>
    <strong>Статус:</strong> <?= Html::encode($task->getStatusLabel()) ?><br>
    <strong>Создана:</strong> <?= Html::encode($task->created_at) ?><br>
    <strong>Обновлена:</strong> <?= Html::encode($task->updated_at) ?><br>
</p>

<?php if ($task->file_task): ?>
    <strong>Файл от
        заказчика:</strong> <?= Html::a('Скачать файл', ['file/download', 'folder' => 'task', 'filename' => basename($task->file_task)]) ?>
    <br>
<?php endif; ?>
<?php if ($project->client_id == Yii::$app->user->id): ?>

    <?= Html::a('Изменить', ['task/update', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'btn btn-warning btn-sm me-1']) ?>
    <?= Html::a('Удалить', ['task/delete', 'projectSlug' => $project->slug, 'slug' => $task->slug], [
        'class' => 'btn btn-danger btn-sm',
        'data' => [
            'confirm' => 'Вы уверены, что хотите удалить эту задачу?',
            'method' => 'post',
        ],
    ]) ?>
<?php endif; ?>
<?php if ($task->status == 'completed'): ?>
    <h3>Ответ фрилансера:</h3>
    <?= Markdown::process($task->freelancer_response) ?>
    <?php if ($task->upload_file): ?>
        <strong>Файл от
            фрилансера:</strong> <?= Html::a('Скачать файл', ['file/download', 'folder' => 'task', 'filename' => basename($task->upload_file)]) ?>
        <br>
    <?php endif; ?>
<?php endif; ?>
<?php if ((!Yii::$app->user->isGuest) && ($project->freelancer == Yii::$app->user->identity->freelancer)): ?>
    <td>
        <div class="mb-4 mt-3">
            <div class="d-flex flex-column flex-sm-row">
                <?= Html::a('Вернутся к проекту', ['project/view', 'slug' => $project->slug], ['class' => 'btn btn-primary btn-sm mb-2 mb-sm-0 me-sm-2']) ?>
                <?php if ($task->status == 'pending'): ?>
                    <?= Html::a('Завершить', ['task/complete', 'projectSlug' => $project->slug, 'slug' => $task->slug], ['class' => 'btn btn-warning btn-sm mb-2 mb-sm-0 me-sm-2']) ?>
                <?php endif; ?>
            </div>
        </div>
    </td>
<?php endif; ?>



