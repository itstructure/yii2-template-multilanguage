<?php

namespace app\models\sitemap;

use yii\helpers\Url;
use dreamjobs\sitemap\interfaces\Basic;
use dreamjobs\sitemap\interfaces\GoogleAlternateLang;
use Itstructure\AdminModule\models\Language;
use app\models\Home;

/**
 * Class SitemapHome
 *
 * @package app\commands\models\sitemap
 */
class SitemapHome extends Home implements Basic, GoogleAlternateLang
{
    /**
     * Handle materials by selecting batch of elements.
     * Increase this value and got more handling speed but more memory usage.
     *
     * @var int
     */
    public $sitemapBatchSize = 10;
    /**
     * List of available site languages
     *
     * @var array [langId => langCode]
     */
    public $sitemapLanguages = [];
    /**
     * If TRUE - Yii::$app->language will be switched for each sitemapLanguages and restored after.
     *
     * @var bool
     */
    public $sitemapSwithLanguages = true;

    /**
     * @var Home
     */
    private $model;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sitemapLanguages = Language::getShortLanguageList();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getSitemapItems($lang = null)
    {
        $this->model = Home::getDefaultHome();

        if (empty($this->model)) {
            return null;
        }

        return [
            [
                'loc' => Url::to('/' . $lang, true),
                'lastmod' => $this->getSitemapLastmod(),
                'changefreq' => $this->getSitemapChangefreq(),
                'priority' => $this->getSitemapPriority(),
                'alternateLinks' => $this->getSitemapAlternateLinks(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getSitemapItemsQuery($lang = null)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLoc($lang = null)
    {
        return Url::to('/' . $lang, true);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLastmod($lang = null)
    {
        return (new \DateTime($this->model->updated_at))->getTimestamp();
    }

    /**
     * @inheritdoc
     */
    public function getSitemapChangefreq($lang = null)
    {
        return static::CHANGEFREQ_MONTHLY;
    }

    /**
     * @inheritdoc
     */
    public function getSitemapPriority($lang = null)
    {
        return static::PRIORITY_8;
    }

    /**
     * @inheritdoc
     */
    public function getSitemapAlternateLinks()
    {
        $buffer = [];

        foreach ($this->sitemapLanguages as $langCode) {
            $buffer[$langCode] = $this->getSitemapLoc($langCode);
        }

        return $buffer;
    }
}
