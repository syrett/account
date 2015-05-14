<?php

Yii::setAlias('backend', dirname(__DIR__));

return [
    'id' => 'app-backend',
    'name' => '老法师',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'admin/default/index',
    'modules' => [
        'admin' => [
            'class' => 'vova07\admin\Module'
        ],
        'users' => [
            'controllerNamespace' => 'vova07\users\controllers\backend'
        ],
        'bank' => [
            'controllerNamespace' => 'vova07\bank\controllers\backend',
        ],
        'cash' => [
            'controllerNamespace' => 'vova07\cash\controllers\backend'
        ],
        'blog' => [
            'class' => 'vova07\blogs\Module',
            'controllerNamespace' => 'vova07\blogs\controllers\backend'
        ],
        'transition' => [
            'class' => 'laofashi\transition\Module',
            'controllerNamespace' => 'laofashi\transition\controllers\backend'
        ],
        'comments' => [
            'isBackend' => true
        ],
        'rbac' => [
            'class' => 'vova07\rbac\Module',
            'isBackend' => true
        ]
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '7fdsf%dbYd&djsb#sn0mlsfo(kj^kf98dfx',
//            'enableCsrfValidation' => false,
         //   'baseUrl' => '/backend'
        ],
        'urlManager' => [
            'rules' => [
                '' => 'admin/default/index',
                '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>'
            ]
        ],
        'view' => [
            'theme' => 'vova07\themes\admin\Theme'
        ],
        'errorHandler' => [
            'errorAction' => 'admin/default/error'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ]
    ],
    'params' => require(__DIR__ . '/params.php')
];
