<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
        'css/site.css',
        'libs/bar-rating/themes/bars-pill.css',
    ];
    public $js = [
        'libs/bar-rating/jquery.barrating.min.js',
        'js/util.js',
        'js/jquery-dateformat.min.js',
        'js/bootstrap-notify.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
