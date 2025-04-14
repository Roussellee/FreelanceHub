<?php
//use yii\helpers\Html;
//use yii\helpers\Url;
//use yii\widgets\ActiveForm;
//use yii2mod\markdown\MarkdownEditor; // Подключаем виджет Markdown
///* @var $model app\models\ProjectForm */
///* @var $categories app\models\Category */
//$this->title = 'Создать проект';
//?>
<!---->
<!--<h1>--><?php //= Html::encode($this->title) ?><!--</h1>-->
<!---->
<!--<div class="project-form">-->
<!--    --><?php //$form = ActiveForm::begin([
//        'id' => 'project-form',
//        'fieldConfig' => [
//            'template' => "{label}\n{input}\n{error}",
//            'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-3'],
//            'inputOptions' => ['class' => 'col-lg-10 form-control'],
//            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback text-white'],
//        ],
//        'options' => ['enctype' => 'multipart/form-data'],
//    ]); ?>
<!--    --><?php //= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
<!---->
<!--    --><?php //= $form->field($model, 'description')->widget(MarkdownEditor::className(), [
//        'options' => ['rows' => 6],
//    ]) ?>
<!---->
<!--    --><?php //= $form->field($model, 'budget')->textInput() ?>
<!--    --><?php //= $form->field($model, 'deadline_date')->input('date') ?>
<!--    --><?php //= $form->field($model, 'deadline_time')->input('time') ?>
<!--    --><?php //= $form->field($model, 'category_id')->dropDownList($categories, ['prompt' => 'Выберите категорию']) ?>
<!--    --><?php //= $form->field($model, 'status')->dropDownList($model->getStatus(), ['prompt' => 'Выберите статус']) ?>
<!---->
<!--    <div class="form-group">-->
<!--        <label>Текущий файл:</label><br>-->
<!--        --><?php //if ($currentFile): ?>
<!--            <a class="btn btn-link"-->
<!--               href="--><?php //= Url::to(['file/download', 'folder' => 'project', 'filename' => basename($currentFile)]) ?><!--">Скачать файл</a>-->
<!--            <br>-->
<!--            --><?php //= Html::checkbox('clear_file', false, ['label' => 'Очистить файл', 'value' => '1']) ?>
<!--        --><?php //else: ?>
<!--            <span>Файл не загружен.</span>-->
<!--        --><?php //endif; ?>
<!--    </div>-->
<!--    --><?php //= $form->field($model, 'file')->fileInput() ?>
<!---->
<!--    <div class="form-group">-->
<!--        --><?php //= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
<!--    </div>-->
<!---->
<!--    --><?php //ActiveForm::end(); ?>
<!--</div>-->

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii2mod\markdown\MarkdownEditor;

/* @var $model app\models\ProjectForm */
/* @var $categories app\models\Category */
/* @var $currentFile */

$this->title = 'Обновить проект: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'slug' => $project->slug]];
$this->params['breadcrumbs'][] = 'Обновить';
?>

<!--<div class="project-update">-->
<!---->
<!--    <h1>--><?php //= Html::encode($this->title) ?><!--</h1>-->
<!---->
<!--    --><?php //$form = ActiveForm::begin([
//        'options' => ['enctype' => 'multipart/form-data'],
//        'fieldConfig' => [
//            'template' => "{label}\n{input}\n{error}",
//            'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-3'],
//            'inputOptions' => ['class' => 'col-lg-10 form-control'],
//            'errorOptions' => ['class' => 'text-danger'],
//        ],
//    ]); ?>
<!---->
<!--    --><?php //= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<!--    --><?php //= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
<!--    --><?php //= $form->field($model, 'budget')->textInput() ?>
<!--    --><?php //= $form->field($model, 'deadline_date')->input('date') ?>
<!--    --><?php //= $form->field($model, 'deadline_time')->input('time') ?>
<!--    --><?php //= $form->field($model, 'category_id')->dropDownList($categories, ['prompt' => 'Выберите категорию']) ?>
<!--    --><?php //= $form->field($model, 'status')->dropDownList([
//        'pending' => 'В ожидании',
//        'in_progress' => 'В процессе',
//        'completed' => 'Завершено',
//        'canceled' => 'Отменено',
//    ], ['prompt' => 'Выберите статус']) ?>
<!--    --><?php //= $form->field($model, 'file')->fileInput() ?>
<!---->
<!--    <div class="form-group">-->
<!--        --><?php //= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
<!--    </div>-->
<!---->
<!--    --><?php //ActiveForm::end(); ?>
<!---->
<!--</div>-->

<h1><?= Html::encode($this->title) ?></h1>

<div class="task-form">

    <?php $form = ActiveForm::begin([
        'id' => 'task-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-10 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 text-danger'],
        ],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->widget(MarkdownEditor::class, []) ?>
        <?= $form->field($model, 'budget')->textInput() ?>
        <?= $form->field($model, 'deadline_date')->input('date') ?>
        <?= $form->field($model, 'deadline_time')->input('time') ?>
        <?= $form->field($model, 'category_id')->dropDownList($categories, ['prompt' => 'Выберите категорию']) ?>
        <?= $form->field($model, 'status')->dropDownList(\app\models\Project::getStatus()) ?>

    <div class="form-group">
        <label>Текущий файл:</label><br>
        <?php if ($currentFile): ?>
            <a class="btn btn-link"
               href="<?= Url::to(['file/download', 'folder' => 'project', 'filename' => basename($currentFile)]) ?>">Скачать файл</a>
            <br>
            <?= Html::checkbox('clear_file', false, ['label' => 'Очистить файл', 'value' => '1']) ?>
        <?php else: ?>
            <span>Файл не загружен.</span>
        <?php endif; ?>
    </div>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>