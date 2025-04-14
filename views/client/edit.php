<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = 'Редактировать профиль клиента';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="client-profile-edit">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_name')->textInput() ?>

    <?= $form->field($model, 'contact_person')->textInput() ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
            'mask' => '+7 (999) 999-99-99',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>