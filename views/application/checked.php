<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ApplicationForm */
/* @var $application app\models\Application */

$this->title = 'Проверка заявки: ' . $application->title;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-checked">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="application-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['readonly' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['readonly' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList([
            'pending' => 'Рассматривается',
            'approved' => 'Одобрить',
            'declined' => 'Отклонить',
        ], [
            'prompt' => 'Выберите статус...',
            'id' => 'status-dropdown',
        ])->label('Статус заявки') ?>

        <div id="reason-rejected" style="display: <?= $model->status === 'declined' ? 'block' : 'none' ?>;">
            <?= $form->field($model, 'reason_rejection')->textarea()->label('Причина отклонения') ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Назад', ['project/view', 'slug' => $application->project->slug], ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?php
$script = <<< JS
$('#status-dropdown').change(function() {
    if ($(this).val() === 'declined') {
        $('#reason-rejected').show();
    } else {
        $('#reason-rejected').hide();
    }
});
JS;
$this->registerJs($script);
?>
