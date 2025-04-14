<?php

use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $application app\models\Application */
$model = new \app\models\ApplicationForm();

$this->title = 'Заявка #' . $application->id . ' от ' . $application->freelancer->user->username . ' для ' . $application->project->client->contact_person;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-view">

    <div class="d-sm-flex justify-content-sm-between">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Вернуться к проекту', ['/project/view', 'slug' => $application->project->slug], ['class' => 'btn btn-primary mt-2']) ?>
    </div>

    <h2>Информация о заявке</h2>
    <p>
        Фрилансер: <?= Html::a($application->freelancer->user->username, ['freelancer/profile', 'username' => $application->freelancer->user->username]) ?></p>
    <p>Email: <?= Html::encode($application->freelancer->user->email) ?></p>
    <p>Причина подачи заявки: <?= Markdown::process($application->description) ?></p>
    <p>Навыки: <?= Markdown::process($application->freelancer->skills) ?></p>
    <p>Опыт работы: <?= Markdown::process($application->freelancer->experience) ?></p>
    <?php if (!empty($application->freelancer->portfolio)): ?>
        <p>Портфолио: <?= Html::encode($application->freelancer->portfolio) ?></p>
    <?php endif; ?>
    <p>Готов к работе: <?= $application->freelancer->availability === 1 ? 'Готов' : 'Не готов'; ?></p>
    <p><strong>Статус:</strong> <?= Html::encode($application->getStatusLabel()) ?></p>
    <p><strong>Дата подачи:</strong> <?= Html::encode($application->created_at) ?></p>
    <p><strong>Дата обновления:</strong> <?= Html::encode($application->updated_at) ?></p>
    <?php if ($application->reason_rejection): ?>
        <p>Причина отмены заявки: <?= Markdown::process($application->reason_rejection) ?></p>
    <?php endif; ?>
    <?php if (Yii::$app->user->identity->role == 'client' && $application->status == 'pending'): ?>
        <!--        --><?php //= Html::a('Редактировать', ['/application/', 'slug' => $application->slug], ['class' => 'btn btn-warning btn-sm me-1 mb-1']) ?>
        <?= Html::a('Принять', ['/application/accept/', 'slug' => $application->slug], ['class' => 'btn btn-success btn-sm me-1 mb-1']) ?>
        <?= Html::button('Отказать', ['class' => 'btn btn-danger btn-sm', 'id' => 'reject-button']) ?>
        <div id="reject-reason" style="display: none;" class="mt-2">
            <?php $form = ActiveForm::begin([
                'action' => ['/application/reject/', 'slug' => $application->slug],
                'method' => 'post',
            ]); ?>
            <?= $form->field($model, 'reason_rejection')->widget(\yii2mod\markdown\MarkdownEditor::class, [])->label('Причина отмены заявки') ?>
            <div class="mt-1">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-danger']) ?>
                <?= Html::button('Отмена', ['class' => 'btn btn-secondary', 'id' => 'cancel-reject']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>
</div>
<script>
    document.getElementById('reject-button').onclick = function () {
        document.getElementById('reject-reason').style.display = 'block';
    };
    document.getElementById('cancel-reject').onclick = function () {
        document.getElementById('reject-reason').style.display = 'none';
    };
</script>

