<?php

namespace app\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Controller;
use app\helpers\BaseHelper;
use app\models\{Page, Category, Contact};
use app\traits\LanguageTrait;
use Itstructure\AdminModule\models\Language;

/**
 * Class BaseController
 *
 * @package app\controllers
 */
class BaseController extends Controller
{
    use LanguageTrait;

    /**
     * @var string
     */
    public $layout = '@app/views/layouts/base';

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->view->params['pages'] = Page::getActiveMenu();
        $this->view->params['categories'] = Category::getActiveMenu();
        $this->view->params['contacts'] = Contact::getDefaultContacts();
        $this->view->params['controllerId'] = Yii::$app->controller->id;

        return parent::beforeAction($action);
    }

    /**
     * @param ActiveRecord|null $model
     */
    protected function setMetaParams(ActiveRecord $model = null)
    {
        if (null === $model) {
            return;
        }

        $this->view->title = $model->{'title_'.$this->shortLanguage};

        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $model->{'metaKeys_'.$this->shortLanguage}
        ]);

        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->{'metaDescription_'.$this->shortLanguage}
        ]);

        $this->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => rtrim(Yii::$app->request->absoluteUrl, '/')
        ]);

        $this->view->registerLinkTag([
            'rel' => 'alternate',
            'hreflang' => 'x-default',
            'href' => Yii::$app->request->hostInfo
        ]);

        foreach (Language::getShortLanguageList() as $shortName) {
            $this->view->registerLinkTag([
                'rel' => 'alternate',
                'hreflang' => $shortName,
                'href' => rtrim(Yii::$app->request->hostInfo, '/') .
                    BaseHelper::getSwitchLanguageLink($shortName, Yii::$app->request)
            ]);
        }
    }
}
