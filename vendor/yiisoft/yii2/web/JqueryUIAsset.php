<?php
/*
 * custom edit by pdwjun
 */

namespace yii\web;

class JqueryUIAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-ui';
    public $css = ['themes/start/jquery-ui.min.css'];
    public $js = [
        'jquery-ui.js',
    ];
}
