<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii2mod\markdown\MarkdownEditor;

/* @var $this yii\web\View */
/* @var $model app\models\TaskForm */
/* @var $task app\models\Task */

$this->title = 'Завершение задачи: ' . $task->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['project/view', 'slug' => $task->project->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="task-complete">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="task-form">
        <p><?= \yii\helpers\Markdown::process($task->project->description) ?></p>
        <div class="form-group">
            <label>Текущий файл:</label><br>
            <?php if ($task->project->file): ?>
                <a class="btn btn-link"
                   href="<?= Url::to(['file/download', 'folder' => 'project', 'filename' => basename($task->project->file)]) ?>">Скачать файл</a>
                <br>
            <?php else: ?>
                <span>Файл не загружен.</span>
            <?php endif; ?>
        </div>

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

        <?= $form->field($model, 'freelancer_response')->widget(MarkdownEditor::class, [
            'options' => ['rows' => 6],
        ]) ?>

        <?= $form->field($model, 'upload_file')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Завершить задачу', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>