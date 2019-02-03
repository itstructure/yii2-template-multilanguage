<?php

namespace app\traits;

use Yii;
use yii\helpers\ArrayHelper;
use app\helpers\BaseHelper;
use Itstructure\AdminModule\models\Language;
use Itstructure\AdminModule\components\AdminView;

/**
 * Class AdminBeforeActionTrait
 *
 * @property AdminView $view
 * @property string $shortLanguage
 * @property Language[] $languages
 *
 * @package app\traits
 */
trait AdminBeforeActionTrait
{
    /**
     * @var array
     */
    private $neighborControllers = [
        'profiles' => 'roles',
        'roles' => 'permissions',
    ];

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->view->mainMenuConfig = require __DIR__ . '/../config/admin/main-menu.php';

        $this->view->homeUrl = '/' . $this->shortLanguage . '/admin';

        $this->view->signOutLink = '/' . $this->shortLanguage . '/logout';

        $this->view->profileLink = '/' . $this->shortLanguage . '/admin/users/view?id='.Yii::$app->getUser()->id;

        Yii::$app->getUser()->loginUrl = '/' . $this->shortLanguage . '/login';

        $this->urlPrefix = '/' . $this->shortLanguage . '/' . $this->module->id . '/' . $action->controller->id . '/';

        if (array_key_exists($action->controller->id, $this->neighborControllers)) {
            $this->urlPrefixNeighbor = '/' . $this->shortLanguage . '/' . $this->module->id . '/' .
                $this->neighborControllers[$action->controller->id] . '/';
        }

        $this->view->userBody = ArrayHelper::map($this->languages, 'name', function ($item) {
            /* @var Language $item */
            return BaseHelper::getSwitchLanguageLink($item->getShortName(), Yii::$app->request);
        });

        return parent::beforeAction($action);
    }
}