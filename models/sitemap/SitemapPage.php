<?php

namespace app\models\sitemap;

use yii\helpers\Url;
use dreamjobs\sitemap\interfaces\Basic;
use dreamjobs\sitemap\interfaces\GoogleAlternateLang;
use Itstructure\AdminModule\models\Language;
use app\models\Page;

/**
 * Class SitemapPage
 *
 * @package app\commands\models\sitemap
 */
class SitemapPage extends Page implements Basic, GoogleAlternateLang
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
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getSitemapItemsQuery($lang = null)
    {
        return static::find()
            ->with([
                'pagesLanguages' => function ($query) use ($lang) {
                    /** @var \yii\db\Query $query */
                    $query->andWhere([
                        'language_id' => Language::findOne([
                            'shortName' => $lang
                        ])->id
                    ]);
                }
            ])
            ->where([
                'active' => 1
            ])
            ->orderBy([
                'id' => SORT_DESC
            ]);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLoc($lang = null)
    {
        return Url::to('/' . $lang . '/page/' . $this->id, true);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLastmod($lang = null)
    {
        $inDateTime = new \DateTime($this->updated_at);

        return $inDateTime->getTimestamp();
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
