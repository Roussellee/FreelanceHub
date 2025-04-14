<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'FreelanceHub';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Добро пожаловать!</h1>

        <p class="lead">Мы приветствуем вас на фриланс-бирже FreelanceHub!</p>
        <?= Html::a('Давайте перейдем к проектам', ['/project/'], ['class' => 'btn btn-lg btn-success']) ?>
    </div>

</div>
