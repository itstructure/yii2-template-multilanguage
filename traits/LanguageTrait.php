<?php

namespace app\traits;

use Yii;
use app\helpers\BaseHelper;
use Itstructure\AdminModule\models\Language;
use Itstructure\AdminModule\components\AdminView;

/**
 * Class LanguageTrait
 *
 * @property AdminView $view
 * @property string $shortLanguage
 * @property Language[] $languages
 *
 * @package app\traits
 */
trait LanguageTrait
{
    /**
     * @var string
     */
    public $shortLanguage;

    /**
     * @var Language[]
     */
    public $languages;

    /**
     * Initialize.
     */
    public function init()
    {
        $this->shortLanguage = Yii::$app->request->get('shortLanguage');

        BaseHelper::setAppLanguage($this->shortLanguage);

        $this->languages = Language::find()->where([
            '!=', 'shortName', $this->shortLanguage
        ])->all();

        $this->view->params['languages'] = $this->languages;

        $this->view->params['shortLanguage'] = $this->shortLanguage;

        parent::init();
    }
}
