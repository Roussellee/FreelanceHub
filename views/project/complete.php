<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii2mod\markdown\MarkdownEditor;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectForm */
/* @var $project app\models\Project */

$this->title = 'Завершение проекта: ' . $project->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['project/view', 'slug' => $project->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="project-complete">

    <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'project-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-10 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 text-danger'],
            ],
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>

        <?= $form->field($model, 'freelancer_response')->widget(MarkdownEditor::class, [
            'options' => ['rows' => 6],
        ]) ?>

        <?= $form->field($model, 'freelancer_requisite')->widget(MarkdownEditor::class, [
            'options' => ['rows' => 6],
        ]) ?>
        <?= $form->field($model, 'final_file')->fileInput() ?>
        <div class="form-group">
            <?= Html::submitButton('Завершить проект', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
</div>
