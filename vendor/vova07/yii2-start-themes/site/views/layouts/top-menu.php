<?php

/**
 * Top menu view.
 *
 * @var \yii\web\View $this View
 */

use vova07\themes\site\widgets\Menu;

echo Menu::widget(
    [
        'options' => [
            'class' => isset($footer) ? 'pull-right' : 'nav navbar-nav navbar-right'
        ],
        'items' => [
            [
                'label' => Yii::t('vova07/themes/site', 'Bank'),
                'url' => ['/bank/default/index']
            ],
            [
                'label' => Yii::t('vova07/themes/site', 'Contacts'),
                'url' => ['/site/default/contacts']
            ],
            [
                'label' => Yii::t('vova07/themes/site', 'Sign In'),
                'url' => ['/users/guest/login'],
                'visible' => Yii::$app->user->isGuest
            ],
            [
                'label' => Yii::t('vova07/themes/site', 'Sign Up'),
                'url' => ['/users/guest/signup'],
                'visible' => Yii::$app->user->isGuest
            ],
            [
                'label' => Yii::t('vova07/themes/site', 'Settings'),
                'url' => '#',
                'template' => '<a href="{url}" class="dropdown-toggle" data-toggle="dropdown">{label} <i class="icon-angle-down"></i></a>',
                'visible' => !Yii::$app->user->isGuest,
                'items' => [
                    [
                        'label' => Yii::t('vova07/themes/site', 'Edit profile'),
                        'url' => ['/users/user/update']
                    ],
                    [
                        'label' => Yii::t('vova07/themes/site', 'Change email'),
                        'url' => ['/users/user/email']
                    ],
                    [
                        'label' => Yii::t('vova07/themes/site', 'Change password'),
                        'url' => ['/users/user/password']
                    ]
                ]
            ],
            [
                'label' => Yii::t('vova07/themes/site', 'Sign Out'),
                'url' => ['/users/user/logout'],
                'visible' => !Yii::$app->user->isGuest
            ]
        ]
    ]
);