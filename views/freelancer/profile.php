<?php
use yii\helpers\Html;
use yii\helpers\Markdown;

/** @var yii\web\View $this */
/** @var app\models\Freelancer $model */

$this->title = 'Профиль фрилансера: ' . $model->user->username;
?>
<h1><?= Html::encode($this->title) ?></h1>
<p><strong>Email:</strong> <?= Html::encode($model->user->email) ?></p>
<p><strong>Роль:</strong> <?= Html::encode($model->user->getRoleList()[$model->user->role] ?? 'Неизвестно') ?></p>
<p><strong>Навыки:</strong> <?= Markdown::process($model->skills) ?></p>
<p><strong>Опыт:</strong> <?= Markdown::process($model->experience) ?></p>
<p><strong>Часовая ставка:</strong> <?= Html::encode($model->hourly_rate) ?>₽</p>
<p>Готов к работе: <?php echo $model->availability === 1 ? 'Готов' : 'Не готов'; ?></p>


<?php if (Yii::$app->user->id == $model->user_id): ?>
    <p>
        <?= Html::a('Редактировать профиль', ['edit'], ['class' => 'btn btn-primary']) ?>
    </p>
<?php endif; ?>
