<?php

return [
    'sourcePath' => dirname(__DIR__),
    'languages' => ['zh'],
    'translator' => 'Yii::t',
    'sort' => true,
    'removeUnused' => true,
    'only' => ['*.php'],
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
    ],
    'format' => 'php',
    'messagePath' => __DIR__,
    'overwrite' => true,
];
