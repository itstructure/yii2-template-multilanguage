<?php

use Itstructure\AdminModule\Module as AdminModule;
use Itstructure\MFUploader\Module as MFUModule;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$baseUrl = require __DIR__ . '/base-url.php';

$config = [
    'id' => 'yii2-template-multilanguage-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'hostInfo' => $baseUrl,
            'scriptUrl' => $baseUrl,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    'modules' => [
        'admin' => [
            'class' => AdminModule::class,
        ],
        'mfuploader' => [
            'class' => MFUModule::class,
        ],
    ],
    'controllerMap' => [
        'sitemap' => [
            'class' => 'Itstructure\Sitemap\SitemapController',
            'baseUrl' => $baseUrl,
            'modelsPath' => '@app/models/sitemap', // Sitemap-data models directory
            'modelsNamespace' => 'app\models\sitemap', // Namespace in [[modelsPath]] files
            'savePathAlias' => '@app/web', // Where would be placed the generated sitemap-files
            'sitemapFileName' => 'sitemap.xml', // Name of main sitemap-file in [[savePathAlias]] directory
        ],
        /*'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],*/
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
