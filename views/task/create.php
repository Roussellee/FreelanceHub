<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2mod\markdown\MarkdownEditor;

/* @var $model app\models\TaskForm */

$this->title = 'Создать задачу';
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="task-form">
    <?php $form = ActiveForm::begin([
        'id' => 'task-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-10 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback text-danger'],
        ],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(MarkdownEditor::class, [
        'options' => ['rows' => 6],
    ]) ?>

    <?= $form->field($model, 'file_task')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
