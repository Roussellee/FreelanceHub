<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2mod\markdown\MarkdownEditor;
use yii\helpers\Url;


$this->title = 'Изменить задачу: ' . $model->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="task-form">

    <?php $form = ActiveForm::begin([
        'id' => 'task-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-10 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedbac text-danger'],
        ],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(MarkdownEditor::class, [
        'options' => ['rows' => 6],
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList($statuses, ['prompt' => 'Выберите статус']) ?>

    <div class="form-group">
        <label>Текущий файл:</label><br>
        <?php if ($currentFile): ?>
            <a class="btn btn-link"
               href="<?= Url::to(['file/download', 'folder' => 'task', 'filename' => basename($currentFile)]) ?>">Скачать файл</a>
            <br>
            <?= Html::checkbox('clear_file', false, ['label' => 'Очистить файл', 'value' => '1']) ?>
        <?php else: ?>
            <span>Файл не загружен.</span>
        <?php endif; ?>
    </div>

    <?= $form->field($model, 'file_task')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
