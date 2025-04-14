<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\RegisterForm $model */

use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните поля для регистрации:</p>

    <div class="row">
        <div class="col-lg-10">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-10 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'example']) ?>
            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'example@mail.ru']) ?>
            <?= $form->field($model, 'role')->dropDownList(User::getRoleList(), ['prompt' => 'Выберите роль на бирже']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите ваш пароль']) ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'Повторите ваш пароль']) ?>


            <div class="form-group">
                <div>
                    <?= Html::submitButton('Зарегестрироваться', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
