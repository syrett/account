<?php

namespace vova07\themes\admin\assets;

use yii\web\AssetBundle;

/**
 * Theme main asset bundle.
 */
class ThemeAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vova07/themes/admin';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/font-awesome.min.css',
        'css/ionicons.min.css',
        'css/AdminLTE.css',
        'css/custom.css'
    ];

    public $js = [
        'js/AdminLTE/app.js',
        'js/custom.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'kartik\select2\Select2Asset'
    ];
}
