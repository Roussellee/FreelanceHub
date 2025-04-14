<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Client $client */

$this->title = 'Профиль клиента: ' . $client->contact_person . ' (' . $client->user->username . ')';
?>
<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Email:</strong> <?= Html::encode($client->user->email) ?></p>
<p><strong>Роль:</strong> <?= Html::encode($client->user->getRoleList()[$client->user->role] ?? 'Неизвестно') ?></p>
<p><strong>Компания:</strong> <?= Html::encode($client->company_name) ?></p>
<p><strong>Контактное лицо:</strong> <?= Html::encode($client->contact_person) ?></p>
<p><strong>Телефон:</strong> <?= Html::encode($client->phone) ?></p>
<?php if (Yii::$app->user->id == $client->user_id): ?>
    <p>
        <?= Html::a('Редактировать профиль', ['edit'], ['class' => 'btn btn-primary']) ?>
    </p>
<?php endif; ?>
