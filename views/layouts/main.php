<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->title]);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100" data-bs-theme="dark">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-black bg-black ']
    ]);
    $navItems = [
        ['label' => 'Проекты / Найти работу', 'url' => ['/project/index'], 'linkOptions' => ['class' => 'custom-link']],
    ];

    if (!Yii::$app->user->isGuest) {
        if (Yii::$app->user->identity->role == 'freelancer') {
            $navItems[] = ['label' => 'В работе', 'url' => ['/freelancer/work'], 'linkOptions' => ['class' => 'custom-link']];
            $navItems[] = ['label' => 'Мой профиль', 'url' => ['/freelancer/profile', 'username' => Yii::$app->user->identity->username], 'linkOptions' => ['class' => 'custom-link']];
        } elseif (Yii::$app->user->identity->role == 'client') {
            $navItems[] = ['label' => 'Мой профиль', 'url' => ['/client/profile', 'username' => Yii::$app->user->identity->username], 'linkOptions' => ['class' => 'custom-link']];
            $navItems[] = ['label' => 'Мои проекты', 'url' => ['/client/index'], 'linkOptions' => ['class' => 'custom-link']];
        } elseif (Yii::$app->user->identity->role == 'admin') {
            $navItems[] = ['label' => 'Админ панель', 'url' => ['/admin/index'], 'linkOptions' => ['class' => 'custom-link']];
        }
        // Добавляем ссылку на выход
        $navItems[] = [
            'label' => 'Выйти (' . Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['class' => 'custom-link', 'data-method' => 'post']
        ];
    } else {
        // Добавляем ссылки на авторизацию и регистрацию для гостей
        $navItems[] = ['label' => 'Авторизация', 'url' => ['/site/login'], 'linkOptions' => ['class' => 'custom-link']];
        $navItems[] = ['label' => 'Регистрация', 'url' => ['/site/register'], 'linkOptions' => ['class' => 'custom-link']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $navItems,
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container mt-3">
        <!--        --><?php //if (!empty($this->params['breadcrumbs'])): ?>
        <!--            --><?php //= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <!--        --><?php //endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-5 py-3 bg-black">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; FreelanceHub <?= date('Y') ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
