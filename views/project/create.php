<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2mod\markdown\MarkdownEditor; // Подключаем виджет Markdown
/* @var $model app\models\ProjectForm */
/* @var $categories app\models\Category */
$this->title = 'Создать проект';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="project-form">
    <?php $form = ActiveForm::begin([
        'id' => 'project-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-10 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedbac text-danger'],
        ],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->widget(MarkdownEditor::className(), [
        'options' => ['rows' => 6],
    ]) ?>

    <?= $form->field($model, 'budget')->textInput() ?>
    <?= $form->field($model, 'file')->fileInput() ?>
    <?= $form->field($model, 'deadline_date')->input('date') ?>
    <?= $form->field($model, 'deadline_time')->input('time') ?>
    <?= $form->field($model, 'category_id')->dropDownList($categories) ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
