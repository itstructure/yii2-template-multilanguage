<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * FontElegantAsset bundle.
 */
class FontElegantAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/fontElegant.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
