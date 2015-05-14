<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'timeZone' => 'Europe/Moscow',
    'modules' => [
        'base' => [

        ],
        'users' => [
            'class' => 'vova07\users\Module',
            'robotEmail' => 'no-reply@domain.com',
            'robotName' => 'Robot'
        ],
        'bank' => [
            'class' => 'vova07\bank\Module',
        ],
        'cash' => [
            'class' => 'vova07\cash\Module'
        ],
        'comments' => [
            'class' => 'vova07\comments\Module'
        ]
    ],
    'components' => [
        'mailer' => [
          'class' => 'yii\swiftmailer\Mailer',
//            'useFileTransport' => true,
            'viewPath' => '@common/mail',
          'transport' => [
              'class' => 'Swift_SmtpTransport',
//              'host' => 'smtp.gmail.com',
//              'username' => 'pdwjun@gmail.com',
//              'password' => 'usixozyohbjsbisw',
//              'port' => '465',
              'host' => 'smtp.126.com',
              'username' => 'pdwjun@126.com',
              'password' => 'rxz5558290555',
              'port' => '587',
//              'auth_mode' => 'login',
              'encryption' => 'tls',
          ],
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true, 'domain' => '.' . DOMAIN],
            'class' => 'yii\web\User',
            'identityClass' => 'vova07\users\models\User',
            'loginUrl' => ['/users/guest/login']
        ],
        'session' => [
            'savePath' => 'd:/temp',
//            'savePath' => '/www/peteraccount/sessions',
            'cookieParams' => ['domain' => '.' . DOMAIN, 'lifetime' => 0],
            'timeout' => 3600,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@root/cache',
            'keyPrefix' => 'yii2start'
        ],
//        'urlManager' => [
//            'enablePrettyUrl' => true,
//            'enableStrictParsing' => true,
//            'showScriptName' => false,
//            'suffix' => '/'
//        ],
        'assetManager' => [
            'linkAssets' => true
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => [
                'user'
            ],
            'itemFile' => '@vova07/rbac/data/items.php',
            'assignmentFile' => '@vova07/rbac/data/assignments.php',
            'ruleFile' => '@vova07/rbac/data/rules.php',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.y',
            'datetimeFormat' => 'HH:mm:ss dd.MM.y'
        ],
        'db' => require(__DIR__ . '/db.php'),
        'dbaccount' => require(__DIR__ . '/dbaccount.php'),
    ],
    'params' => require(__DIR__ . '/params.php')
];
