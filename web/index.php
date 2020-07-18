<?php

use yii\helpers\ArrayHelper;
use Itstructure\AdminModule\Module as AdminModule;
use Itstructure\RbacModule\Module as RbacModule;
use Itstructure\MFUploader\Module as MFUModule;

if (file_exists(__DIR__ . '/../config/environment.php')) {
    require __DIR__ . '/../config/environment.php';
}

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

Yii::setAlias('@app', dirname(__DIR__));
Yii::setAlias('@admin', AdminModule::getBaseDir());
Yii::setAlias('@rbac', RbacModule::getBaseDir());
Yii::setAlias('@mfuploader', MFUModule::getBaseDir());

$webConfig = require __DIR__ . '/../config/web.php';
$adminConfig = require __DIR__ . '/../config/admin/admin.php';

$config = ArrayHelper::merge($webConfig, $adminConfig);

$app = new yii\web\Application($config);

$app->run();
