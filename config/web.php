<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ljdashglasgjsakgkjasg',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'register' => 'site/register',
                'logout' => 'site/logout',
//                'file/download/<folder>/<filename>' => 'file/download',

                'freelancer/profile/<username:\w+>' => 'freelancer/profile',
                'client/profile/<username:\w+>' => 'client/profile',
                'freelancer/edit' => 'freelancer/edit',
                'freelancer/applications' => 'project/applications',
                'client/edit' => 'client/edit',
                'client' => 'client/index',

                'project' => 'project/index',
                'project/create' => 'project/create',
                'project/<slug>' => 'project/view',
                'project/update/<slug>' => 'project/update',
                'project/delete/<slug>' => 'project/delete',
                'project/complete/<slug>' => 'project/complete',

                'project/<projectSlug>/task/create' => 'task/create',
                'project/<projectSlug>/task/<slug>' => 'task/view',
                'project/<projectSlug>/task/<slug>/update' => 'task/update',
                'project/<projectSlug>/task/<slug>/delete' => 'task/delete',
                'project/<projectSlug>/task/<slug>/complete' => 'task/complete',

                'project/<projectSlug>/application/create' => 'application/create',
                'project/<projectSlug>/applications' => 'project/applications',
                'application/<slug>' => 'application/view',
                'application/<slug>/accept' => 'application/accept',
                'application/<slug>/reject' => 'application/reject',
                'application/<slug>/delete' => 'application/delete',


            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
