<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dataTables.bootstrap.css',
        'css/site.css',
        'css/custom.css',
        'css/custom-skin.css',
        'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700'
    ];
    public $js = [
        'js/jquery.dataTables.js',
        'js/dataTables.bootstrap.js',
        'js/main.js',
        '../js/util.js',
        '../js/jquery-dateformat.min.js',
        'https://unpkg.com/ionicons@4.1.0/dist/ionicons.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'dmstr\web\AdminLteAsset',
    ];
}
