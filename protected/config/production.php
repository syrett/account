<?php

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'components' => array(
            'cache' => array(
                'class' => 'CApcCache',
            ),
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=account',
                'emulatePrepare' => true,
                'username' => 'jason',
                'password' => 'lrc207107',
                'charset' => 'utf8',
                'schemaCachingDuration' => 3600,
            ),
            'log' => array(
                'routes' => array(
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'error, warning',
                    ),
                    array(
                        'class' => 'CEmailLogRoute',
                        'levels' => 'error, warning',
                        'emails' => 'inasyrov@yandex.ru',
                    ),
                ),
            ),
        ),
    )
);