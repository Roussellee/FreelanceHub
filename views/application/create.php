<?php

use app\models\ApplicationForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model ApplicationForm
 */
$this->title = 'Создание заявки на участие в проекте';

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="application-create">

    <p>Заполните форму ниже, чтобы подать заявку на участие в проекте.</p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'description')->widget(\yii2mod\markdown\MarkdownEditor::class, []) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить заявку', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
