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
        'css/font-awesome.min.css',
        'css/animate.min.css',
        'css/preloader.css',
        'css/style.css',
        'css/navbar.css',
    ];
    public $js = [
        'js/preloader.js',
        'js/custom.js',
        'js/feedback.js',
        'js/navbar.js',
        'js/wow.min.js',
        'https://www.google.com/recaptcha/api.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
