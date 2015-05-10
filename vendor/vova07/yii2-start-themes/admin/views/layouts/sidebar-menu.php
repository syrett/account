<?php

/**
 * Sidebar menu layout.
 *
 * @var \yii\web\View $this View
 */

use vova07\themes\admin\widgets\Menu;

echo Menu::widget(
    [
        'options' => [
            'class' => 'sidebar-menu'
        ],
        'items' => [
            [
                'label' => Yii::t('vova07/themes/admin', 'Dashboard'),
                'url' => Yii::$app->homeUrl,
                'icon' => 'fa-dashboard',
                'active' => Yii::$app->request->url === Yii::$app->homeUrl
            ],
            [
                'label' => Yii::t('vova07/themes/admin', 'Bank'),
                'url' => ['/bank/default/index'],
                'icon' => 'fa-book',
                'visible' => Yii::$app->user->can('administrateBank') || Yii::$app->user->can('BViewBank'),
            ],
            [
                'label' => Yii::t('vova07/themes/admin', 'Cash'),
                'url' => ['/cash/default/index'],
                'icon' => 'fa-book',
                'visible' => Yii::$app->user->can('administrateBank') || Yii::$app->user->can('BViewBank'),
            ],
//            [
//                'label' => Yii::t('vova07/themes/admin', 'Staff'),
//                'url' => ['/bank/default/index'],
//                'icon' => 'fa-book',
//                'visible' => Yii::$app->user->can('administrateBank') || Yii::$app->user->can('BViewBank'),
//            ],
//            [
//                'label' => Yii::t('vova07/themes/admin', 'Term'),
//                'url' => ['/bank/default/index'],
//                'icon' => 'fa-book',
//                'visible' => Yii::$app->user->can('administrateBank') || Yii::$app->user->can('BViewBank'),
//            ],
//            [
//                'label' => Yii::t('vova07/themes/admin', 'Sale'),
//                'url' => ['/bank/default/index'],
//                'icon' => 'fa-book',
//                'visible' => Yii::$app->user->can('administrateBank') || Yii::$app->user->can('BViewBank'),
//            ],
//            [
//                'label' => Yii::t('vova07/themes/admin', 'Purchase'),
//                'url' => ['/bank/default/index'],
//                'icon' => 'fa-book',
//                'visible' => Yii::$app->user->can('administrateBank') || Yii::$app->user->can('BViewBank'),
//            ],
//            [
//                'label' => Yii::t('vova07/themes/admin', 'Inventory'),
//                'url' => ['/bank/default/index'],
//                'icon' => 'fa-book',
//                'visible' => Yii::$app->user->can('administrateBank') || Yii::$app->user->can('BViewBank'),
//            ],
//            [
//                'label' => Yii::t('vova07/themes/admin', 'Change'),
//                'url' => ['/bank/default/index'],
//                'icon' => 'fa-book',
//                'visible' => Yii::$app->user->can('administrateBank') || Yii::$app->user->can('BViewBank'),
//            ],

        ]
    ]
);