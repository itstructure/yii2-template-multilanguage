<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * CollapseAsset bundle.
 */
class CollapseAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap/js';
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'collapse.js',
        'transition.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}
