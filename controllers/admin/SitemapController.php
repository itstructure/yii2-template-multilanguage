<?php

namespace app\controllers\admin;

use Yii;
use dreamjobs\sitemap\SitemapDataHandler;
use Itstructure\AdminModule\controllers\AdminController;
use app\traits\{LanguageTrait, AdminBeforeActionTrait};

/**
 * Class SitemapController
 *
 * @package app\controllers\admin
 */
class SitemapController extends AdminController
{
    use LanguageTrait, AdminBeforeActionTrait;

    /** @var string Alias to directory contains sitemap-models */
    public $modelsPath = '@app/models/sitemap';

    /** @var string Namespace of sitemap-models files */
    public $modelsNamespace = 'app\models\sitemap';

    /** @var string Path to saving sitemap-files. As webroot: "http://example.com" */
    public $savePathAlias = '@app/web';

    /** @var string Name of sitemap-file, saved to webroot: "http://example.com/sitemap.xml" */
    public $sitemapFileName = 'sitemap.xml';

    /** @var array Default config for sitemap builder */
    public $builderConfig = [
        'urlsPerFile' => 100,
    ];

    /** @var string Base Url for sitemap links. As webroot: "http://example.com" */
    public $baseUrl;

    /**
     * Render sitemap.
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {

            $this->export();

            return $this->redirect([
                '/'.$this->shortLanguage.'/admin/sitemap'
            ]);
        }

        return $this->render('index', [
            'sitemapContent' => $this->readSitemapFile()
        ]);
    }

    /**
     * Export sitemap in to "savePathAlias" path.
     *
     * @return void
     */
    private function export()
    {
        $dataHandler = new SitemapDataHandler($this->savePathAlias, $this->sitemapFileName, $this->baseUrl, [
            'builderConfig' => $this->builderConfig,
        ]);

        $models = $dataHandler->getModelsClasses($this->modelsPath, $this->modelsNamespace);
        $dataHandler->handleModels($models);
    }

    /**
     * Read sitemap file.
     *
     * @return null|string
     */
    private function readSitemapFile()
    {
        $filePath = Yii::getAlias($this->savePathAlias) . '/' . $this->sitemapFileName;

        if (!file_exists($filePath)) {
            return null;
        }

        $fileContent = file_get_contents($filePath);

        return htmlspecialchars($fileContent, ENT_QUOTES);
    }
}
