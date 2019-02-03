<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class AppAsset
 *
 * @package app\assets
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/fontElegant.css',
        'css/prettyPhoto.css',
        'css/flexslider.css',
        'css/style.css',
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
        'js/jquery.prettyPhoto.js',
        'js/jquery-ui.min.js',
        'js/jquery.twitter.js',
        'js/superfish.min.js',
        'js/jquery.flexslider-min.js',
        'js/myscript.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
