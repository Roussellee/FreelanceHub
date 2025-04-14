<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2mod\markdown\MarkdownEditor; // Подключаем виджет Markdown
use yii\helpers\HtmlPurifier; // Подключаем HtmlPurifier

/* @var $this yii\web\View */
/* @var $model app\models\Freelancer */

$this->title = 'Редактировать профиль фрилансера';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-edit">
    <h1 class="profile-title"><?= Html::encode($this->title) ?></h1>
    <div class="container-form">
        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal'],
        ]); ?>

        <?= $form->field($model, 'skills')->widget(MarkdownEditor::className(), [
            'options' => ['rows' => 1],
        ]) ?>

        <?= $form->field($model, 'experience')->widget(MarkdownEditor::className(), [
            'options' => ['rows' => 1],
        ]) ?>

        <?= $form->field($model, 'hourly_rate')->textInput(['type' => 'number', 'step' => '0.01']) ?>

        <?= $form->field($model, 'availability')->checkbox() ?>

        <div class="form-group d-flex gap-2">
            <?= Html::submitButton('Сохранить', [
                'class' => 'btn save-button',
            ]) ?>
            <a href="<?= \yii\helpers\Url::toRoute(['/freelancer/profile', 'username' => Yii::$app->user->identity->username]) ?>" class="btn save-button">Вернутся</a>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
